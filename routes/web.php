<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes Admin - VIEW (untuk halaman)
Route::prefix('admin')
    ->middleware(['auth', 'role:admin,superadmin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/users', [UserController::class, 'indexView'])->name('users.index');
    });

// Routes Admin - API (untuk AJAX request)
Route::prefix('api/admin')
    ->middleware(['auth', 'role:admin,superadmin'])
    ->name('api.admin.')
    ->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.list');
    });

// Routes Superadmin - API
Route::prefix('api/admin')
    ->middleware(['auth', 'role:superadmin'])
    ->name('api.admin.')
    ->group(function () {
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });