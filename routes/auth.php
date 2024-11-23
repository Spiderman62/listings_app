<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;
Route::middleware('guest')->group(function () {
    //------------------- Register -------------------//
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');

    //------------------- Login -------------------//
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login');
});

Route::middleware('auth')->group(function () {
    //------------------- Logout -------------------//
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    //------------------- Email verify -------------------//
    Route::get('/email/verify', [VerificationController::class,'notice'])->name('verification.notice');
});
