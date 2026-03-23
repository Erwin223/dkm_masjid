<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\OtpPasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Rute Lupa Password OTP (Menggantikan bawaan Laravel)
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
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
