<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// Route::prefix('auth')->group(function() {
//     // Signup
//     Route::get('/google/signup/redirect', [GoogleAuthController::class, 'signupRedirect']);
//     Route::get('/google/signup/callback', [GoogleAuthController::class, 'signupCallback']);

//     // Login
//     Route::get('/google/login/redirect', [GoogleAuthController::class, 'loginRedirect']);
//     Route::get('/google/login/callback', [GoogleAuthController::class, 'loginCallback']);
// });



