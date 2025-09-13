<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;


// ----------------- AUTH ROUTES -----------------
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Logout (POST only for security)
Route::post('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// ----------------- PROTECTED ROUTES -----------------
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Other pages
    Route::get('/data', fn() => view('data'))->name('data');
    Route::get('/category', fn() => view('category'))->name('category');
    Route::get('/item-condition', fn() => view('item-condition'))->name('item-condition');
    Route::get('/settings', fn() => view('settings'))->name('settings');
    Route::get('/help', fn() => view('help'))->name('help');
});

// ----------------- DEFAULT ROUTE -----------------
Route::get('/', function () {
    return redirect()->route('login');
});
