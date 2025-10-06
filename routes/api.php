<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\MoreController;

Route::middleware(["auth:sanctum"])->group(function() {
    Route::get('/user/check', [UserController::class, 'checkUser']);
    Route::get('/user', [UserController::class, 'getUser']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/newApikey', [UserController::class, 'newKey']);
    Route::post('/newsletter_subscription', [UserController::class, 'newsletterSubscription']);
    Route::post('/newsletter_unsubscription', [UserController::class, 'newsletterUnsubscription']);
    Route::post('/paystack/verify-payment', [PaystackController::class, 'verifyPayment']);
    Route::post('/upgrade/placeorder', [OrderController::class, 'handleOrder']);
});

Route::post('/paystack/webhook', [PaystackController::class, 'handleWebhook']);
Route::post('/message_us', [MoreController::class, 'messageUs']);

Route::middleware(["throttle:api"])->group(function() {
    Route::get('presidents', [ApiController::class, 'presidents']);
    Route::get('presidents/us_presidents', [ApiController::class, 'usPresidents']);
    Route::get('/countries', [ApiController::class, 'countries']);
});

Route::get('/items', function() {
    return response()->json([
        'fruits' => ["Hola", "Mangoe", "Apple", "Cashew", "Paw-paw", "Strawberry"],
        'sports' => ["Football", "Tennis", "Volley Ball"]
    ]);
});
