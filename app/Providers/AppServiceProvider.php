<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        RateLimiter::for('otp-email', function (Request $request) {
            $email = strtolower((string) $request->input('email', ''));
            $key = $request->ip().'|'.$email;

            return Limit::perMinute(5)->by($key);
        });

        RateLimiter::for('otp-verify', function (Request $request) {
            $email = strtolower((string) $request->session()->get('reset_email', ''));
            $key = $request->ip().'|'.$email;

            return Limit::perMinute(10)->by($key);
        });

        RateLimiter::for('otp-resend', function (Request $request) {
            $email = strtolower((string) $request->session()->get('reset_email', ''));
            $key = $request->ip().'|'.$email;

            return Limit::perMinute(2)->by($key);
        });

        RateLimiter::for('login-otp-verify', function (Request $request) {
            $adminId = (string) $request->session()->get('login_otp_admin_id', '');
            $key = $request->ip().'|'.$adminId;

            return Limit::perMinute(10)->by($key);
        });

        RateLimiter::for('login-otp-resend', function (Request $request) {
            $adminId = (string) $request->session()->get('login_otp_admin_id', '');
            $key = $request->ip().'|'.$adminId;

            return Limit::perMinute(3)->by($key);
        });
    }
}
