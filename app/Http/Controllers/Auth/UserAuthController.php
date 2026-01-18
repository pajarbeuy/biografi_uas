<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Controller untuk Login User (Non-Admin)
 * 
 * Controller ini menangani autentikasi untuk user biasa (bukan admin/superadmin).
 * User dengan role 'user' login di sini dan akan diarahkan ke homepage.
 * 
 * Pemisahan login:
 * - User reguler (role: user) → Login di sini → Redirect ke /home
 * - Admin/SuperAdmin → Harus login via Filament (/admin/login)
 * 
 * Jika admin/superadmin coba login di sini, akan ditolak dengan pesan error.
 */
class UserAuthController extends Controller
{
    /**
     * Display the login view.
     */
    public function showLoginForm()
    {
        return view('auth.user-login');
    }

    /**
     * Handle incoming authentication request
     * 
     * Method ini:
     * 1. Validasi email dan password
     * 2. Attempt login dengan remember me option
     * 3. Cek role user setelah berhasil login:
     *    - Jika role = 'user' → ALLOWED, redirect ke /home
     *    - Jika role = admin/superadmin → REJECTED, logout paksa
     * 4. Regenerate session untuk keamanan
     * 
     * @param Request $request Request dengan email dan password
     * @return \Illuminate\Http\RedirectResponse Redirect response
     * @throws ValidationException Jika credentials salah atau role tidak sesuai
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect based on role
            if ($user->role === 'user') {
                return redirect()->intended('/home');
            }
            
            // Admin/SuperAdmin should use Filament login
            Auth::logout();
            return back()->withErrors([
                'email' => 'Admin dan SuperAdmin silakan login melalui panel admin.',
            ])->onlyInput('email');
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    /**
     * Logout user dan destroy session
     * 
     * Method ini:
     * 1. Logout user dari guard
     * 2. Invalidate session
     * 3. Regenerate CSRF token
     * 4. Redirect ke homepage
     * 
     * @param Request $request Request object
     * @return \Illuminate\Http\RedirectResponse Redirect ke homepage
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
