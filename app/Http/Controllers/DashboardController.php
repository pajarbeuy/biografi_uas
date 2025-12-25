<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->session()->get('biomed_role');

        // require login (simple)
        if (!$request->session()->has('user_name') || !$role) {
            return redirect()->route('login');
        }

        // Simple set of cards per role
        $cards = [
            'user' => [
                ['title' => 'Profile', 'desc' => 'Lihat dan edit profil kamu'],
                ['title' => 'Data Diri', 'desc' => 'Informasi pribadi dan kontak'],
            ],
            'admin' => [
                ['title' => 'Users', 'desc' => 'Kelola pengguna'],
                ['title' => 'Reports', 'desc' => 'Lihat laporan sistem'],
                ['title' => 'Settings', 'desc' => 'Pengaturan aplikasi'],
            ],
            'super' => [
                ['title' => 'Site Settings', 'desc' => 'Pengaturan global situs'],
                ['title' => 'Admins', 'desc' => 'Kelola admin dan izin'],
                ['title' => 'Logs', 'desc' => 'Audit dan logs sistem'],
                ['title' => 'Migrations', 'desc' => 'Manajemen migrasi & seeding'],
            ],
        ];

        $cardsForRole = $cards[$role] ?? $cards['user'];

        return view('dashboard', [
            'role' => $role,
            'cards' => $cardsForRole,
        ]);
    }

    public function setRole(Request $request)
    {
        $role = $request->input('role', 'user');
        if (!in_array($role, ['user', 'admin', 'super'])) {
            $role = 'user';
        }
        $request->session()->put('biomed_role', $role);
        return redirect()->back();
    }

    public function clearRole(Request $request)
    {
        $request->session()->forget('biomed_role');
        return redirect()->back();
    }
}
