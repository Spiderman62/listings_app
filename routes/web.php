<?php

use App\Http\Controllers\AdminController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController;
// Listings route
Route::get('/', [ListingController::class,'index'])->name('home');
Route::resource('listing', ListingController::class)->except('index');
// Profile route
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['verified'])->name('dashboard');
    Route::get('/profile',[ProfileController::class,'edit'])->middleware(['password.confirm'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class,'updateInfo'])->name('profile.info');
    Route::put('/profile',[ProfileController::class,'updatePassword'])->name('profile.password');
    Route::delete('/profile',[ProfileController::class,'destroy'])->name('profile.destroy');
});

// Admin route
Route::middleware(['auth','verified',Admin::class])
    ->controller(AdminController::class)
    ->group(function () {
    Route::get('/admin','index')->name('admin.index');
    Route::get('/users/{user}/show','show')->name('user.show');
    Route::put('/admin/{user}/role','role')->name('admin.role');
    Route::put('/listing/{listing}/approve','approve')->name('admin.approve');
});
// Auth route
require __DIR__.'/auth.php';
