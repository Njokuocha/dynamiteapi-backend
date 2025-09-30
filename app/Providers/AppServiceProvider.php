<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function ($request) {
            // Per-user limit if authenticated, otherwise per IP
            return Limit::perMinute(20)->by(optional($request->user())->id ?: $request->ip())
            ->response(function () {
                return response()->json([
                    'message' => 'Too Many Attempts! Max request of 20 allowed per minute', // ✅ Custom JSON response
                ], 429);
            });
            // return Limit::perMinute(60)->by($request->ip());
        });

        // RateLimiter::for('signup', function ($request) {
        //     return Limit::perMinute(5)->by($request->ip()); // Only 5 signups per minute per IP
        // });

        // RateLimiter::for('login', function ($request) {
        //     return Limit::perMinute(10)->by($request->ip()); // 10 login attempts per minute per IP
        // });

    }

}
