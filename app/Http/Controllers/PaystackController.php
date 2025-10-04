<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\User;

class PaystackController extends Controller
{
    public function verifyPayment(Request $request)
    {
        $reference = $request->reference;

        $secretKey = env('PAYSTACK_SECRET_KEY');

        $response = Http::withToken($secretKey)
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if ($response->successful() && $response['data']['status'] === 'success') {
            return response()->json(['status' => 'success', 'data' => $response['data']]);
        }

        return response()->json(['status' => 'failed', 'data' => $response['data'] ?? null], 400);
    }


    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();

        // Verify Paystack signature
        $signature = $request->header('x-paystack-signature');
        if ($signature !== hash_hmac('sha512', $payload, env('PAYSTACK_SECRET_KEY'))) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $event = json_decode($payload, true);

        Log::info('Paystack Webhook:', $event); // For debugging

        if ($event['event'] === 'charge.success') {
            $reference = $event['data']['reference'];
            $amount = $event['data']['amount'] / 100; // from Kobo to Naira
            $email = $event['data']['customer']['email'];

            $order = Order::where('reference', $reference)
                ->where('email', $email)->first();

            // Mark order as paid in DB here - .........
            User::where('id', $order->user->id)->update([
                'rlimit' => $order->limit,
                'rfig' => 0,
            ]);

            $order->update([
                "status" => "paid"
            ]);
            
        }

        return response()->json(['status' => 'ok']);
    }
}
