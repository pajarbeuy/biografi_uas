<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Superadmin punya akses ke semua
        if ($user->role === 'superadmin') {
            return $next($request);
        }

        // Check apakah user punya salah satu role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}