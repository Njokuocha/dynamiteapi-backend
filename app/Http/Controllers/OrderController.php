<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function handleOrder(Request $request)
    {
        $upgrade_plan = [
            ["tier" => 1, "amount" => 1200, "tier_id" => "#tier1", "tier_name" => "Tier 1", "limit" => "3000"],
            ["tier" => 2, "amount" => 5400, "tier_id" => "#tier2", "tier_name" => "Tier 2", "limit" => "5000"],
            ["tier" => 3, "amount" => 11500, "tier_id" => "#tier3", "tier_name" => "Tier 3", "limit" => "7500"],
            ["tier" => 4, "amount" => 15000, "tier_id" => "#tier4", "tier_name" => "Tier 4", "limit" => "unlimited"]
        ];

        $reference = str()->random(20).time();

        foreach($upgrade_plan as $plan){
            if($plan["tier"] === $request->input('tier')){
                $order = Order::create([
                    "amount" => $plan['amount'],
                    "email" => $request->user()->email,
                    "reference" => $reference,
                    "user_id" => $request->user()->id,
                    "plan" => $plan['tier_name'],
                    "plan_id" => $plan['tier_id'],
                    "limit" => $plan['limit']
                ]);
            }
        }

        $order = Order::where('reference', $reference)->first();

        return response()->json([
            "status" => "success",
            "order" => [
                "email" => $order->email,
                "amount" => $order->amount * 100,
                "reference" => $order->reference
            ]
        ]);
    }
}
