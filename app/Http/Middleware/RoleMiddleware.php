<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk memeriksa role user
 * 
 * Middleware ini digunakan untuk melindungi route berdasarkan role user.
 * Hanya user dengan role yang sesuai yang dapat mengakses route tersebut.
 * 
 * Superadmin memiliki akses ke semua route tanpa batasan.
 * 
 * Cara penggunaan di routes:
 * Route::get('/admin', function() {...})->middleware('role:admin,superadmin');
 */
class RoleMiddleware
{
    /**
     * Handle incoming request dan cek role user
     * 
     * Method ini akan:
     * 1. Cek apakah user sudah login
     * 2. Jika belum, redirect ke halaman login
     * 3. Jika sudah login, cek apakah role-nya sesuai
     * 4. Superadmin otomatis lolos semua pengecekan
     * 5. User lain harus memiliki salah satu role yang diizinkan
     * 
     * @param Request $request Request yang masuk
     * @param Closure $next Closure untuk melanjutkan request
     * @param mixed ...$roles Role yang diizinkan mengakses route (bisa lebih dari satu)
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException Jika user tidak punya akses (403)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Superadmin punya akses ke semua route
        if ($user->role === 'superadmin') {
            return $next($request);
        }

        // Check apakah user punya salah satu role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, tampilkan error 403
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}