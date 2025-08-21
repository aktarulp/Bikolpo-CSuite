<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {


    // Partner Authentication
    Route::get('partner/login', [AuthenticatedSessionController::class, 'create'])
        ->name('partner.login');
    Route::post('partner/login', [AuthenticatedSessionController::class, 'store']);
    
    Route::get('partner/register', [\App\Http\Controllers\Auth\PartnerRegistrationController::class, 'showRegistrationForm'])
        ->name('partner.register');
    Route::post('partner/register', [\App\Http\Controllers\Auth\PartnerRegistrationController::class, 'register'])
        ->name('partner.register.store');
    Route::get('partner/verify-otp', [\App\Http\Controllers\Auth\PartnerRegistrationController::class, 'showOtpVerificationForm'])
        ->name('partner.verify-otp');
    Route::post('partner/verify-otp', [\App\Http\Controllers\Auth\PartnerRegistrationController::class, 'verifyOtp'])
        ->name('partner.verify-otp.store');
    Route::post('partner/resend-otp', [\App\Http\Controllers\Auth\PartnerRegistrationController::class, 'resendOtp'])
        ->name('partner.resend-otp');
    
    // Partner registration success page (no middleware required)
    Route::get('partner/registration-success', [\App\Http\Controllers\Auth\PartnerRegistrationController::class, 'showRegistrationSuccess'])
        ->name('partner.registration.success');

    // Student Authentication
    Route::get('student/login', [AuthenticatedSessionController::class, 'create'])
        ->name('student.login');
    Route::post('student/login', [AuthenticatedSessionController::class, 'store']);
    
    Route::get('student/register', [\App\Http\Controllers\Auth\StudentRegistrationController::class, 'showRegistrationForm'])
        ->name('student.register');
    Route::post('student/register', [\App\Http\Controllers\Auth\StudentRegistrationController::class, 'register'])
        ->name('student.register.store');

    // Standard Authentication Routes - Removed general registration to prevent bypassing OTP
    // Route::get('register', [RegisteredUserController::class, 'create'])
    //     ->name('register');
    // Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
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
