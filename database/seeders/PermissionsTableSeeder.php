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
            'role.view', 'role.create', 'role.edit', 'role.delete',
            'users.view', 'users.edit', 'users.delete',
            'purchases.view', 'purchases.refund', 'purchases.delete',
            'payments.view', 'payments.edit', 'payments.delete',
            'lectures.view', 'lectures.create', 'lectures.edit', 'lectures.delete',
            'materials.view', 'materials.create', 'materials.edit', 'materials.delete',
            'quizzes.view', 'quizzes.create', 'quizzes.edit', 'quizzes.delete',
            'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
            'courses.view', 'courses.create', 'courses.edit', 'courses.delete',
            'instructors.view', 'instructors.create', 'instructors.edit', 'instructors.delete',
            'orders.view', 'orders.create', 'orders.edit', 'orders.delete',
            'payments.view', 'payments.create', 'payments.edit', 'payments.delete',
            'reports.view', 'reports.create', 'reports.edit', 'reports.delete',
            'settings.view', 'settings.create', 'settings.edit', 'settings.delete',
            'permissions.view', 'permissions.create', 'permissions.edit', 'permissions.delete',
            'notifications.view', 'notifications.create', 'notifications.edit', 'notifications.delete',
            'contact_messages.view', 'contact_messages.delete',
            'comments.view', 'comments.delete',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Create Admin Role
        $role = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);

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
