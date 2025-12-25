<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:user,admin,super',
        ]);

        $request->session()->put('user_name', $data['name']);
        $request->session()->put('biomed_role', $data['role']);

        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['user_name', 'biomed_role']);
        return redirect('/home');
    }
}
