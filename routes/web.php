<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\UserRegisterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect root to home
Route::get('/', function () {
    return redirect('/home');
});

// Public pages (accessible to everyone)
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/profile-tokoh', [App\Http\Controllers\BiografiController::class, 'index'])->name('profile-tokoh');

Route::get('/reference', function () {
    return view('reference');
})->name('reference');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/tambah-tokoh', [App\Http\Controllers\BiografiController::class, 'create'])
    ->middleware('auth')
    ->name('tambah-tokoh');

Route::post('/tambah-tokoh', [App\Http\Controllers\BiografiController::class, 'store'])
    ->middleware('auth')
    ->name('tambah-tokoh.store');

// User authentication routes (custom, bukan Breeze)
Route::middleware('guest')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login']);
    
    Route::get('/register', [UserRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [UserRegisterController::class, 'register']);
});

// User authenticated routes
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
    
    // Profile routes (available for all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});