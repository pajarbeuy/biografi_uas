<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'view biografis',
            'create biografis',
            'edit biografis',
            'delete biografis',
            'approve biografis',
            
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdminRole = Role::create(['name' => 'superadmin']);
        $superAdminRole->givePermissionTo(Permission::all());

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view biografis',
            'create biografis',
            'edit biografis',
            'delete biografis',
            'approve biografis',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
        ]);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view biografis',
            'create biografis',
        ]);

        // Assign roles to existing users based on their 'role' column
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
