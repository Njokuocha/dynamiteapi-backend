<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageusMail;

class MoreController extends Controller
{
    public function messageUs(Request $request)
    {
        $request->validate([
            "name" => "string|required",
            "email" => "email|required",
            "subject" => "string|required",
            "message" => "string|required",
        ]);
        $name = $request->name;
        $email = $request->email;
        $phone_number = $request->phone_number;
        $subject = $request->subject;
        $message = $request->message;

        Mail::to($email)
            ->send(new MessageusMail($name, $email, $phone_number, $subject, $message));

        return response()->json([
            'status' => 'success',
        ]);
    }
}
