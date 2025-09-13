<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (protected)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');
