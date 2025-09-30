<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ApiController extends Controller
{
    public function usPresidents(Request $request)
    {
        $apiKey = $request->header('X-ApiKey');
        $checkKey = User::where('apiKey', $apiKey)->first();
        if(!$checkKey) return response()->json([
           'message' => 'Invalid Api Credential' 
        ], 401);
        $path = resource_path('data/us_presidents.json');
        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found']);
        }
        $json = File::get($path);

        User::where('id', $request->user()->id)
            ->update(['rfig' => DB::raw("rfig + 1")]);

        return response()->json(json_decode($json, true));
    }

    public function countries(Request $request)
    {
        $apiKey = $request->header('X-ApiKey');
        $checkKey = User::where('apiKey', $apiKey)->first();
        if(!$checkKey) return response()->json([
           'message' => 'Invalid Api Credential' 
        ], 401);
        $path = resource_path('data/countries.json');
        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found']);
        }

        $json = File::get($path);
        User::where('id', $request->user()->id)
            ->update(['rfig' => DB::raw("rfig + 1")]);

        return response()->json(json_decode($json, true));
    }
    // public function countries(Request $request)
    // {
    //     $apiKey = $request->header('X-ApiKey');
    //     $checkKey = User::where('apiKey', $apiKey)->first();
    //     if(!$checkKey) return response()->json([
    //        'message' => 'Invalid Api Credential' 
    //     ], 401);
    //     $path = storage_path('app/data/countries.json');
    //     if (!file_exists($path)) {
    //         return response()->json(['error' => 'File not found']);
    //     }

    //     $json = file_get_contents($path);
    //     User::where('id', $request->user()->id)
    //         ->update(['rfig' => DB::raw("rfig + 1")]);

    //     return response()->json(json_decode($json, true));
    // }
}
