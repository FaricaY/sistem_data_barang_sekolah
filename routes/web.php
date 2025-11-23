<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\ProfileController;

// ----------------- AUTH ROUTES -----------------
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 

// ----------------- PROTECTED ROUTES -----------------
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('items', ItemController::class);
    Route::resource('categories', CategoriesController::class)->except(['show']);
    Route::resource('condition', ConditionController::class)->except(['show']);

    // --- SETTINGS & PROFILE ROUTES ---
    
    // FIX 1: Point this to the ProfileController so it can load $user and $profile data
    Route::get('/settings', [ProfileController::class, 'index'])->name('settings'); 
    
    // FIX 2: Point this to the ProfileController's 'edit' method
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    
    // FIX 3: Changed PUT to PATCH to match the forms and fix the error
    Route::patch('/profile/update', [ProfileController::class, 'updateGeneral'])->name('profile.update');
    Route::patch('/settings/notifications', [ProfileController::class, 'updateNotifications'])->name('settings.notifications.update');
    Route::patch('/settings/security', [ProfileController::class, 'updateSecurity'])->name('settings.security.update');
    
    // Help Page
    Route::get('/help', fn() => view('help.index'))->name('help.index'); 

});

// ----------------- DEFAULT ROUTE -----------------
Route::get('/', function () {
    return redirect()->route('login');
});