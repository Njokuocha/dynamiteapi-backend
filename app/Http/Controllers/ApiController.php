<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ApiController extends Controller
{
    // us presidents
    public function usPresidents(Request $request)
    {
        // check key availability
        $apiKey = $request->header('X-ApiKey');
        if(!$apiKey) return response()->json([
           'message' => 'No Api Credential Found' 
        ], 401);

        // check key validity
        $checkKey = User::where('apiKey', $apiKey)->first();
        if(!$checkKey) return response()->json([
           'message' => 'Invalid Api Credential' 
        ], 401);

        // process request
        $path = resource_path('data/us_presidents.json');
        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found']);
        }
        $json = File::get($path);
        $feedback = json_decode($json, true);
    
        // query - ?limit handler
        $limit = $request->input('limit');
        if(!is_numeric($limit) && isset($limit)) return response()->json([
            "message" => "Invalid Request",
        ], 400);
        if($limit){
            $newItems = collect($feedback);
            $feedback = $newItems->take($request->input('limit'));
        }

        // query - ?random handler
        $random = $request->input('random');
        $accept = ["true", "false"];
        if(isset($random) && !in_array($random, $accept)) return response()->json([
            "message" => "Invalid Request",
        ], 400);
        if($random && $random === "true"){
            $randomItems = collect($feedback)->shuffle();
            $feedback = $randomItems->all();
        }

        User::where('apiKey', $apiKey)
            ->update([
                'rfig' => DB::raw("rfig + 1")
            ]);

        return response()->json($feedback);
    }

    // presidents
    public function presidents(Request $request)
    {
        // check key availability
        $apiKey = $request->header('X-ApiKey');
        if(!$apiKey) return response()->json([
           'message' => 'No Api Credential Found' 
        ], 401);

        // check key validity
        $checkKey = User::where('apiKey', $apiKey)->first();
        if(!$checkKey) return response()->json([
           'message' => 'Invalid Api Credential' 
        ], 401);

        // process request
        $path = resource_path('data/presidents.json');
        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found']);
        }
        $json = File::get($path);
        $feedback = json_decode($json, true);
    
        // query - ?limit handler
        $limit = $request->input('limit');
        if(!is_numeric($limit) && isset($limit)) return response()->json([
            "message" => "Invalid Request",
        ], 400);
        if($limit){
            $newItems = collect($feedback);
            $feedback = $newItems->take($request->input('limit'));
        }

        // query - ?random handler
        $random = $request->input('random');
        $accept = ["true", "false"];
        if(isset($random) && !in_array($random, $accept)) return response()->json([
            "message" => "Invalid Request",
        ], 400);
        if($random && $random === "true"){
            $randomItems = collect($feedback)->shuffle();
            $feedback = $randomItems->all();
        }

        User::where('apiKey', $apiKey)
            ->update([
                'rfig' => DB::raw("rfig + 1")
            ]);

        return response()->json($feedback);
    }

    // countries
    public function countries(Request $request)
    {
        // check key availability
        $apiKey = $request->header('X-ApiKey');
        if(!$apiKey) return response()->json([
           'message' => 'No Api Credential Found' 
        ], 401);

        // check key validity
        $checkKey = User::where('apiKey', $apiKey)->first();
        if(!$checkKey) return response()->json([
           'message' => 'Invalid Api Credential' 
        ], 401);

        // process request
        $path = resource_path('data/countries.json');
        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found']);
        }

        $json = File::get($path);
        $items = json_decode($json, true);
        $feedback = [];

        foreach($items as $item){
            $imgs = [
                "sm" => [
                    "img1" => "https://flagsapi.com/{$item["code"]}/flat/16.png",
                    "img2" => "https://flagsapi.com/{$item["code"]}/shiny/16.png",
                ],
                "md" => [
                    "img1" => "https://flagsapi.com/{$item["code"]}/flat/24.png",
                    "img2" => "https://flagsapi.com/{$item["code"]}/shiny/24.png",
                ],
                "lg" => [
                    "img1" => "https://flagsapi.com/{$item["code"]}/flat/32.png",
                    "img2" => "https://flagsapi.com/{$item["code"]}/shiny/32.png",
                ],
                "xl" => [
                    "img1" => "https://flagsapi.com/{$item["code"]}/flat/48.png",
                    "img2" => "https://flagsapi.com/{$item["code"]}/shiny/48.png",
                ],
                "xxl" => [
                    "img1" => "https://flagsapi.com/{$item["code"]}/flat/64.png",
                    "img2" => "https://flagsapi.com/{$item["code"]}/shiny/64.png",
                ],
            ];

            $item["images"] = $imgs;
            array_push($feedback, $item);
        }

        // query - ?limit handler
        $limit = $request->input('limit');
        if(!is_numeric($limit) && isset($limit)) return response()->json([
            "message" => "Invalid Request",
        ], 400);
        if($limit){
            $newItems = collect($feedback);
            $feedback = $newItems->take($request->input('limit'));
        }

        // query - ?random handler
        $random = $request->input('random');
        $accept = ["true", "false"];
        if(isset($random) && !in_array($random, $accept)) return response()->json([
            "message" => "Invalid Request",
        ], 400);
        if($random && $random === "true"){
            $randomItems = collect($feedback)->shuffle();
            $feedback = $randomItems->all();
        }
        
        User::where('apiKey', $apiKey)
            ->update([
                'rfig' => DB::raw("rfig + 1")
            ]);

        return response()->json($feedback);
    }

}
