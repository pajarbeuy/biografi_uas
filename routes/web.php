<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BiografiController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/reference', function () {
    return view('reference');
})->name('reference');

// Sitemap route
Route::get('/sitemap.xml', function () {
    $biografis = \App\Models\Biografi::where('status', 'published')->get();
    return response()->view('sitemap', compact('biografis'))
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

// Profile Tokoh (Biography listing and detail)
Route::get('/profile-tokoh', [BiografiController::class, 'index'])->name('profile-tokoh');
Route::get('/profile-tokoh/{tokoh:slug}', [BiografiController::class, 'show'])->name('profile-tokoh.show');

// Add Biography (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/tambah-tokoh', [BiografiController::class, 'create'])->name('tambah-tokoh');
    Route::post('/tambah-tokoh', [BiografiController::class, 'store'])->name('tambah-tokoh.store');
});

// User Dashboard Routes (requires authentication)
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::delete('/biografi/{biografi}', [UserDashboardController::class, 'destroy'])->name('biografi.destroy');
    Route::get('/biografi/{biografi}/edit', [UserDashboardController::class, 'edit'])->name('biografi.edit');
    Route::put('/biografi/{biografi}', [UserDashboardController::class, 'update'])->name('biografi.update');
});

// Profile Routes (Laravel Breeze default)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication Routes
require __DIR__.'/auth.php';
