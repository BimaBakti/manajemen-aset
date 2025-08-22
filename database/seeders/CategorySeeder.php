<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Komputer & Laptop',
                'code' => 'COMP',
                'description' => 'Perangkat komputer, laptop, dan aksesoris',
                'icon' => 'computer',
                'depreciation_years' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Furniture',
                'code' => 'FURN',
                'description' => 'Meja, kursi, lemari, dan perabotan kantor',
                'icon' => 'chair',
                'depreciation_years' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Kendaraan',
                'code' => 'VEH',
                'description' => 'Mobil, motor, dan kendaraan operasional',
                'icon' => 'car',
                'depreciation_years' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Elektronik',
                'code' => 'ELEC',
                'description' => 'Printer, scanner, proyektor, dan perangkat elektronik',
                'icon' => 'printer',
                'depreciation_years' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Peralatan Kantor',
                'code' => 'OFFICE',
                'description' => 'ATK, telepon, dan peralatan kantor lainnya',
                'icon' => 'phone',
                'depreciation_years' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'AC & Pendingin',
                'code' => 'AC',
                'description' => 'Air conditioner, kipas, dan peralatan pendingin',
                'icon' => 'wind',
                'depreciation_years' => 10,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
