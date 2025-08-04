<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/Welcome', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('Dashboard.offers');
});

// Administrator Routes
Route::prefix('admin/')->name('admin.')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        // Login Routes
        Route::get('login', 'index')->name('login')->defaults('guard', 'admin');
        Route::post('login', 'login')->name('login.submit')->defaults('guard', 'admin');
        Route::get('index-forget-password', 'indexForgetPass')->name('forgetPass')->defaults('guard', 'admin');
        Route::post('forget-password', 'forgetPass')->name('forgetPass.submit')->defaults('guard', 'admin');
        Route::post('reset-password', 'resetPass')->name('resetPass.submit')->defaults('guard', 'admin');
        Route::get('verified-password/{id}', 'confirm')->name('confirm')->defaults('guard', 'admin');
        Route::get('email-verified', 'emailVerified')->name('emailVerified')->defaults('guard', 'admin');
        Route::get('email-verified-success', 'emailVerifiedS')->name('emailVerifiedS')->defaults('guard', 'admin');
        // Register Routes
        Route::get('register', 'indexregister')->name('register')->defaults('guard', 'admin');
        Route::post('register', 'register')->name('register.submit')->defaults('guard', 'admin');
        // Default Routes
        Route::get('dashboard', 'dashboard')->name('dashboard')->defaults('guard', 'admin');
    });
});

// Freelancers Routse
Route::prefix('freelancer/')->name('freelancer.')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        // Login Routes
        Route::get('login', 'index')->name('login')->defaults('guard', 'freelancer');
        Route::post('login', 'login')->name('login.submit')->defaults('guard', 'freelancer');
        Route::get('index-forget-password', 'indexForgetPass')->name('forgetPass')->defaults('guard', 'freelancer');
        Route::post('forget-password', 'forgetPass')->name('forgetPass.submit')->defaults('guard', 'freelancer');
        Route::post('reset-password', 'resetPass')->name('resetPass.submit')->defaults('guard', 'freelancer');
        Route::get('verified-password/{id}', 'confirm')->name('confirm')->defaults('guard', 'freelancer');
        Route::get('email-verified', 'emailVerified')->name('emailVerified')->defaults('guard', 'freelancer');
        Route::get('email-verified-success', 'emailVerifiedS')->name('emailVerifiedS')->defaults('guard', 'freelancer');
        // Register Routes
        Route::get('register', 'indexregister')->name('register')->defaults('guard', 'freelancer');
        Route::post('register', 'register')->name('register.submit')->defaults('guard', 'freelancer');
        // Default Routes
        Route::get('dashboard', 'dashboard')->name('dashboard')->defaults('guard', 'freelancer');
    });
});

// Clients Routes
Route::prefix('user/')->controller(AuthController::class)->name('web.')->group(function () {
    // Login Routes
    Route::get('login', 'index')->name('login')->defaults('guard', 'web');
    Route::post('login', 'login')->name('login.submit')->defaults('guard', 'web');
    Route::get('index-forget-password', 'indexForgetPass')->name('forgetPass')->defaults('guard', 'web');
    Route::post('forget-password', 'forgetPass')->name('forgetPass.submit')->defaults('guard', 'web');
    Route::post('reset-password', 'resetPass')->name('resetPass.submit')->defaults('guard', 'web');
    Route::get('verified-password/{id}', 'confirm')->name('confirm')->defaults('guard', 'web');
    Route::get('email-verified', 'emailVerified')->name('emailVerified')->defaults('guard', 'web');
    Route::get('email-verified-success', 'emailVerifiedS')->name('emailVerifiedS')->defaults('guard', 'web');
    // Register Routes
    Route::get('register', 'indexregister')->name('register')->defaults('guard', 'web');
    Route::post('register', 'register')->name('register.submit')->defaults('guard', 'web');
    // Default Routes
    Route::get('dashboard', 'dashboard')->name('dashboard')->defaults('guard', 'web');
});

// Email verification sent
Route::get('verify-email/{guard}', [EmailVerificationController::class, 'verify'])->name('verification.email')->where('guard', 'web|freelancer|admin');

// Reset Password
Route::get('reset-password/{guard}', [ResetPasswordController::class, 'indexReset'])->name('resetPasword')->where('guard', 'web|freelancer|admin');
// Route::get('reset-password', [ResetPasswordController::class, 'reset'])->name('resetPasword.supmit')->where('guard', 'web|freelancer|admin');

