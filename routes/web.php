<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

Route::inertia('/', 'Home')->name('home');
Route::get('/register', [RegisterController::class, 'create'])->name('register');
