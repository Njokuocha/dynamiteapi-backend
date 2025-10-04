<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterMail;
use App\Mail\UnsubscribeMail;
use App\Models\Emails;
use App\Models\Order;

class UserController extends Controller
{
    public function checkUser(Request $request)
    {
        if($request->user()) return response()->json([
            'auth' => 'active'
        ]);
    }

    public function getUser(Request $request)
    {
        return response()->json([
            "data" => $request->user(),
            "newsletter" => $request->user()->newsletter()->first(),
            "upgrades" => Order::where('user_id', $request->user()->id)
                            ->where('status', 'paid')->get(),
        ]);
    }

    // logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        // $request->user()->tokens()->delete(); // for all token across devices
        return response()->json([
            'status' => 'success',
        ]);
    }

    // generate new api key
    public function newKey(Request $request)
    {
        $apiKey = str()->random(30);
        User::where('id', $request->user()->id)
            ->update(['apikey' => $apiKey]);
        
        return response()->json([
            'key' => $apiKey,
        ]);
    }

    // newsletter subscription
    public function newsletterSubscription(Request $request)
    {
        $email = $request->input('email');
        
        $subscriber = Emails::firstOrCreate(
            ["email" => $email],
            [
                "email" => $email,
                "user_id" => $request->user()->id
            ]
        );

        if($subscriber->status === 'active') return response()->json([
            "message" => "Already Subscribed",
            "status" => "subscribed"
        ]);
        else $subscriber->update(["status" => "active"]);
        
        Mail::to($email)->send(new NewsletterMail());
        
        return response()->json([
            'status' => 'success',
            'message' => 'Newsletter Subscription Successful!',
        ]);
    }

    // newsletter unsubscription
    public function newsletterUnsubscription(Request $request)
    {
        $subscriber = User::find($request->user()->id);

        Emails::where('user_id', $subscriber->id)->update([
            'status' => 'inactive',
        ]);
        
        Mail::to($subscriber->newsletter()->first()->email)->send(new UnsubscribeMail());
        
        return response()->json([
            'status' => 'success',
            'message' => 'You Just Unsubscribed to our Newsletter',
        ]);
    }

    // public function sendMail()
    // {
    //     Mail::to('njokuochafrancis99@gmail.com')->send(new NewsletterMail());
    //     return response()->json([
    //         'message' => 'Mail sent now!'
    //     ]);
    // }
}
