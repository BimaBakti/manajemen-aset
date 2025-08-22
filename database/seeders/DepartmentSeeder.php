<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Human Resources',
                'code' => 'HR',
                'description' => 'Department yang mengelola sumber daya manusia',
                'is_active' => true,
            ],
            [
                'name' => 'Information Technology',
                'code' => 'IT',
                'description' => 'Department yang mengelola teknologi informasi',
                'is_active' => true,
            ],
            [
                'name' => 'Finance & Accounting',
                'code' => 'FIN',
                'description' => 'Department yang mengelola keuangan dan akuntansi',
                'is_active' => true,
            ],
            [
                'name' => 'Operations',
                'code' => 'OPS',
                'description' => 'Department yang mengelola operasional perusahaan',
                'is_active' => true,
            ],
            [
                'name' => 'Marketing',
                'code' => 'MKT',
                'description' => 'Department yang mengelola pemasaran dan promosi',
                'is_active' => true,
            ],
            [
                'name' => 'General Affairs',
                'code' => 'GA',
                'description' => 'Department yang mengelola urusan umum',
                'is_active' => true,
            ],
        ];

        foreach ($departments as $department) {
            \App\Models\Department::create($department);
        }
    }
}
