<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});

// Dashboard routes (simple role switcher for demo)
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/role', [DashboardController::class, 'setRole'])->name('role.set');
Route::post('/role/clear', [DashboardController::class, 'clearRole'])->name('role.clear');

// Simple auth (session-based for demo)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
