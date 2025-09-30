<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiController;




Route::middleware(["auth:sanctum"])->group(function() {
    Route::get('/user', [UserController::class, 'getUser']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/newApikey', [UserController::class, 'newKey']);
});

Route::middleware(["auth:sanctum", "throttle:api"])->group(function() {
    Route::get('/us_presidents', [ApiController::class, 'usPresidents']);
    Route::get('/countries', [ApiController::class, 'countries']);
});
