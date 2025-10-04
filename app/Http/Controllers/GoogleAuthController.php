<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    // Handling both Login and Signup at one go 
    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'avatar' => $googleUser->getAvatar(),
                // 'password' => bcrypt(str()->random(16)), // random password
            ]
        );

        // Update picture url
            User::where("email", $googleUser->getEmail())
                ->update(['avatar' => $googleUser->getAvatar()]);

        // Auth::login($user); for laravel session-based auth (blade views)

        // If using Sanctum or JWT, generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Redirect back to React app with token
        return redirect("http://localhost:3000/auth/callback?token={$token}");
        // return redirect("https://dynamiteapi.vercel.app/auth/callback?token={$token}");
    }

    // Signup redirect
    public function signupRedirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    // Signup callback
    public function signupCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        if (User::where('email', $googleUser->getEmail())->exists()) {
            return response()->json(['error' => 'User already exists'], 409);
        }

        // 409 - http code when a request cannot be processed due to duplicates

        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'password' => bcrypt(str()->random(16)),
            'avatar' => $googleUser->getAvatar(),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    // Login redirect
    public function loginRedirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    // Login callback
    public function loginCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            return response()->json(['error' => 'No account found. Please sign up first.'], 404);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

}
