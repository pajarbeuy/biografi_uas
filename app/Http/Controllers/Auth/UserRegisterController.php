<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

/**
 * Controller untuk Registrasi User Baru
 * 
 * Controller ini menangani pendaftaran user baru dengan:
 * - Validasi input (name, email, password)
 * - Hash password untuk keamanan
 * - Default role assignment: 'user'
 * - Auto-login setelah registrasi berhasil
 * - Redirect ke homepage (/home)
 * 
 * Semua user yang register akan otomatis mendapat role 'user' (bukan admin).
 */
class UserRegisterController extends Controller
{
    /**
     * Display the registration view.
     */
    public function showRegistrationForm()
    {
        return view('auth.user-register');
    }

    /**
     * Handle incoming registration request
     * 
     * Method ini:
     * 1. Validasi input:
     *    - Name: Required, string, max 255
     *    - Email: Required, unique di tabel users
     *    - Password: Required, confirmed, memenuhi rules default Laravel
     * 2. Create user baru dengan:
     *    - Password di-hash menggunakan Hash::make()
     *    - Role default: 'user' (bukan admin/superadmin)
     * 3. Auto-login user yang baru dibuat
     * 4. Redirect ke /home
     * 
     * @param Request $request Request dengan data registrasi
     * @return \Illuminate\Http\RedirectResponse Redirect ke homepage
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user', // Default role is user
        ]);

        Auth::login($user);

        return redirect('/home');
    }
}
