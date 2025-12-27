<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class InstructorRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create Instructor role if it doesn't exist
        $role = Role::firstOrCreate(['name' => 'Instructor']);
        
        // You can add specific permissions for instructors here if needed
    }
}
