<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
Route::middleware('guest')->group(function () {
    //------------------- Register -------------------//
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');

    //------------------- Login -------------------//
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login');

    //------------------- Reset password -------------------//
    Route::get('/forgot-password',[ResetPasswordController::class,'requestPass'])->name('password.request');

    Route::post('/forgot-password', [ResetPasswordController::class,'sendMail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class,'resetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class,'resetHandler'])->middleware('guest')->name('password.update');
});

Route::middleware('auth')->group(function () {
    //------------------- Logout -------------------//
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    //------------------- Email verify -------------------//
    Route::get('/email/verify', [VerificationController::class,'notice'])->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [VerificationController::class,'handler'])->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification',[VerificationController::class,'resend'])->middleware('throttle:6,1')->name('verification.send');

    Route::get('/confirm-password',[ConfirmPasswordController::class,'create'])->name('password.confirm');
    Route::post('/confirm-password', [ConfirmPasswordController::class,'store'])->middleware('throttle:6,1');
});
