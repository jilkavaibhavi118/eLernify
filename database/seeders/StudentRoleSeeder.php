<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class StudentRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create student role if it doesn't exist
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // You can add specific permissions for students here if needed
        // For now, students will have basic access to enroll in courses
    }
}
