<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\OtpPasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:6,1');

    Route::get('login/verify-otp', [AuthenticatedSessionController::class, 'showLoginOtpForm'])
        ->name('login.otp.form');

    Route::post('login/verify-otp', [AuthenticatedSessionController::class, 'verifyLoginOtp'])
        ->middleware('throttle:login-otp-verify')
        ->name('login.otp.verify');

    Route::post('login/resend-otp', [AuthenticatedSessionController::class, 'resendLoginOtp'])
        ->middleware('throttle:login-otp-resend')
        ->name('login.otp.resend');

    Route::get('forgot-password', [OtpPasswordController::class, 'showEmailForm'])
        ->name('password.request');

    Route::post('forgot-password', [OtpPasswordController::class, 'sendOtp'])
        ->middleware('throttle:otp-email')
        ->name('password.email');

    Route::get('verify-otp', [OtpPasswordController::class, 'showVerifyForm'])
        ->name('password.otp.verify');

    Route::post('verify-otp', [OtpPasswordController::class, 'verifyOtp'])
        ->middleware('throttle:otp-verify')
        ->name('password.otp.verify.post');

    Route::post('resend-otp', [OtpPasswordController::class, 'resendOtp'])
        ->middleware('throttle:otp-resend')
        ->name('password.otp.resend');

    Route::get('reset-password', [OtpPasswordController::class, 'showResetForm'])
        ->name('password.otp.reset');

    Route::post('reset-password', [OtpPasswordController::class, 'resetPassword'])
        ->name('password.otp.reset.post');
});

Route::middleware('auth')->group(function () {
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
