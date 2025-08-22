<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        \App\Models\User::create([
            'name' => 'Admin System',
            'email' => 'admin@manajemenaset.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'department_id' => 2, // IT Department
            'employee_id' => 'EMP001',
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Procurement User
        \App\Models\User::create([
            'name' => 'Budi Procurement',
            'email' => 'procurement@manajemenaset.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'department_id' => 6, // GA Department
            'employee_id' => 'EMP002',
            'role' => 'procurement',
            'is_active' => true,
        ]);

        // Manager User
        \App\Models\User::create([
            'name' => 'Sari Manager',
            'email' => 'manager@manajemenaset.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'department_id' => 1, // HR Department
            'employee_id' => 'EMP003',
            'role' => 'manager',
            'is_active' => true,
        ]);

        // Employee Users
        \App\Models\User::create([
            'name' => 'Andi Karyawan',
            'email' => 'andi@manajemenaset.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'department_id' => 2, // IT Department
            'employee_id' => 'EMP004',
            'role' => 'employee',
            'is_active' => true,
        ]);

        \App\Models\User::create([
            'name' => 'Rini Finance',
            'email' => 'rini@manajemenaset.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'department_id' => 3, // Finance Department
            'employee_id' => 'EMP005',
            'role' => 'employee',
            'is_active' => true,
        ]);
    }
}
