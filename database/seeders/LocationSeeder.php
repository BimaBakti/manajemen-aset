<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Office IT',
                'code' => 'OFF-IT',
                'description' => 'Ruang kantor IT',
                'building' => 'Gedung A',
                'floor' => 'Lantai 2',
                'room' => 'Room 201',
                'department_id' => 2, // IT Department
                'is_active' => true,
            ],
            [
                'name' => 'Office HR',
                'code' => 'OFF-HR',
                'description' => 'Ruang kantor HR',
                'building' => 'Gedung A',
                'floor' => 'Lantai 1',
                'room' => 'Room 101',
                'department_id' => 1, // HR Department
                'is_active' => true,
            ],
            [
                'name' => 'Office Finance',
                'code' => 'OFF-FIN',
                'description' => 'Ruang kantor Finance',
                'building' => 'Gedung A',
                'floor' => 'Lantai 1',
                'room' => 'Room 102',
                'department_id' => 3, // Finance Department
                'is_active' => true,
            ],
            [
                'name' => 'Meeting Room A',
                'code' => 'MTG-A',
                'description' => 'Ruang meeting utama',
                'building' => 'Gedung A',
                'floor' => 'Lantai 1',
                'room' => 'Room 103',
                'is_active' => true,
            ],
            [
                'name' => 'Warehouse',
                'code' => 'WH-01',
                'description' => 'Gudang penyimpanan',
                'building' => 'Gedung B',
                'floor' => 'Lantai 1',
                'is_active' => true,
            ],
            [
                'name' => 'Server Room',
                'code' => 'SRV-01',
                'description' => 'Ruang server',
                'building' => 'Gedung A',
                'floor' => 'Lantai 2',
                'room' => 'Room 202',
                'department_id' => 2, // IT Department
                'is_active' => true,
            ],
        ];

        foreach ($locations as $location) {
            \App\Models\Location::create($location);
        }
    }
}
