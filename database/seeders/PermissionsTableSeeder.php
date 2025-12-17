<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions
        $permissions = [
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',
            'users.view',
            'users.edit',
            'purchases.view',
            'purchases.refund',
            'payments.view',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Admin Role
        $role = Role::firstOrCreate(['name' => 'Admin']);

        // Sync all permissions to Admin role
        $role->syncPermissions($permissions);

        // Create Admin User
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Assign Admin role to user
        $user->assignRole($role);
    }
}
