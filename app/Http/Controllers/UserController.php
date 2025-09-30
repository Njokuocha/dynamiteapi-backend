<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        // $request->user()->tokens()->delete(); // for all token across devices
        return response()->json([
            'status' => 'success',
        ]);
    }

    public function newKey(Request $request)
    {
        $apiKey = str()->random(30);
        User::where('id', $request->user()->id)
            ->update(['apikey' => $apiKey]);
        
        return response()->json([
            'key' => $apiKey,
        ]);
    }
}
