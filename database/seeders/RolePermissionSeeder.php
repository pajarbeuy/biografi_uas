<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

/**
 * Seeder untuk Role dan Permission menggunakan Spatie Laravel Permission
 * 
 * Seeder ini bertanggung jawab untuk:
 * 1. Membuat semua permission yang dibutuhkan aplikasi
 * 2. Membuat role (superadmin, admin, user)
 * 3. Menetapkan permission ke masing-masing role
 * 4. Assign role ke user yang sudah ada berdasarkan kolom 'role'
 * 
 * Struktur Permission:
 * - Biografi: view, create, edit, delete, approve
 * - User: view, create, edit, delete
 * - Category: view, create, edit, delete
 * 
 * Struktur Role:
 * - superadmin: Semua permission
 * - admin: Permission untuk biografi (termasuk approve) dan kategori
 * - user: Hanya view dan create biografi
 */
class RolePermissionSeeder extends Seeder
{
    /**
     * Jalankan database seeder
     * 
     * Method ini akan:
     * 1. Membuat 13 permission untuk biografi, user, dan kategori
     * 2. Membuat 3 role: superadmin, admin, user
     * 3. Assign permission ke setiap role sesuai hierarki:
     *    - superadmin: ALL permissions
     *    - admin: Biografi (semua) + Category (semua)
     *    - user: Biografi (view + create saja)
     * 4. Assign role ke existing users berdasarkan nilai kolom 'role'
     * 
     * @return void
     */
    public function run(): void
    {
        // Buat semua permission yang dibutuhkan aplikasi
        $permissions = [
            // Permission untuk Biografi
            'view biografis',
            'create biografis',
            'edit biografis',
            'delete biografis',
            'approve biografis', // Khusus untuk admin/superadmin
            
            // Permission untuk User Management
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Permission untuk Category Management
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
        ];

        // Loop dan buat setiap permission di database
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Buat role SUPERADMIN dengan semua permission
        $superAdminRole = Role::create(['name' => 'superadmin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Buat role ADMIN dengan permission biografi dan kategori
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view biografis',
            'create biografis',
            'edit biografis',
            'delete biografis',
            'approve biografis', // Admin bisa approve biografi
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
        ]);

        // Buat role USER dengan permission terbatas (hanya lihat dan buat biografi)
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view biografis',
            'create biografis',
        ]);

        // Assign role ke existing users berdasarkan kolom 'role' mereka
        // Ini untuk backward compatibility dengan sistem lama
        $users = User::all();
        foreach ($users as $user) {
            if ($user->role === 'superadmin') {
                $user->assignRole('superadmin');
            } elseif ($user->role === 'admin') {
                $user->assignRole('admin');
            } else {
                $user->assignRole('user');
            }
        }

        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('Existing users have been assigned roles based on their current role column.');
    }
}
