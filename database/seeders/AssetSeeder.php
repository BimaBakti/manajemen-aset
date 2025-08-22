<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = [
            [
                'name' => 'MacBook Pro 14 inch',
                'description' => 'MacBook Pro dengan M2 chip untuk development tim',
                'category_id' => 1, // Komputer & Laptop
                'location_id' => 1, // Office IT
                'serial_number' => 'MBP2024001',
                'model' => 'MacBook Pro 14"',
                'brand' => 'Apple',
                'purchase_price' => 25000000.00,
                'purchase_date' => '2024-01-15',
                'warranty_expiry' => '2026-01-15',
                'status' => 'in_use',
                'condition' => 'excellent',
                'assigned_to' => 4, // Andi Karyawan
                'assigned_at' => '2024-01-20',
                'specifications' => [
                    'CPU' => 'Apple M2',
                    'RAM' => '16GB',
                    'Storage' => '512GB SSD',
                    'Display' => '14.2-inch Liquid Retina XDR',
                ],
            ],
            [
                'name' => 'Dell XPS 13',
                'description' => 'Ultrabook untuk tim finance',
                'category_id' => 1, // Komputer & Laptop  
                'location_id' => 3, // Office Finance
                'serial_number' => 'DXPS2024002',
                'model' => 'XPS 13 9320',
                'brand' => 'Dell',
                'purchase_price' => 18000000.00,
                'purchase_date' => '2024-02-01',
                'warranty_expiry' => '2027-02-01',
                'status' => 'in_use',
                'condition' => 'excellent',
                'assigned_to' => 5, // Rini Finance
                'assigned_at' => '2024-02-05',
                'specifications' => [
                    'CPU' => 'Intel Core i7-1250U',
                    'RAM' => '16GB LPDDR5',
                    'Storage' => '512GB SSD',
                    'Display' => '13.4-inch InfinityEdge',
                ],
            ],
            [
                'name' => 'HP LaserJet Pro M404dn',
                'description' => 'Printer monochrome untuk kantor',
                'category_id' => 4, // Elektronik
                'location_id' => 2, // Office HR
                'serial_number' => 'HPM404001',
                'model' => 'LaserJet Pro M404dn',
                'brand' => 'HP',
                'purchase_price' => 3500000.00,
                'purchase_date' => '2024-03-10',
                'warranty_expiry' => '2025-03-10',
                'status' => 'available',
                'condition' => 'good',
                'specifications' => [
                    'Type' => 'Monochrome Laser Printer',
                    'Print Speed' => '38 ppm',
                    'Connectivity' => 'Ethernet, USB',
                    'Paper Capacity' => '250 sheets',
                ],
            ],
            [
                'name' => 'Executive Desk Mahogany',
                'description' => 'Meja kerja executive dari kayu mahogany',
                'category_id' => 2, // Furniture
                'location_id' => 2, // Office HR
                'model' => 'Executive Mahogany 160x80',
                'brand' => 'Custom Furniture',
                'purchase_price' => 8500000.00,
                'purchase_date' => '2023-12-15',
                'status' => 'in_use',
                'condition' => 'excellent',
                'assigned_to' => 3, // Sari Manager
                'assigned_at' => '2023-12-20',
            ],
            [
                'name' => 'Toyota Avanza G',
                'description' => 'Kendaraan operasional perusahaan',
                'category_id' => 3, // Kendaraan
                'location_id' => 5, // Warehouse
                'serial_number' => 'AVANZA2023001',
                'model' => 'Avanza G MT',
                'brand' => 'Toyota',
                'purchase_price' => 220000000.00,
                'purchase_date' => '2023-06-01',
                'warranty_expiry' => '2026-06-01',
                'status' => 'available',
                'condition' => 'good',
                'specifications' => [
                    'Engine' => '1.3L VVT-i',
                    'Transmission' => '5-Speed Manual',
                    'Fuel Type' => 'Gasoline',
                    'Seating' => '7 seats',
                ],
            ],
            [
                'name' => 'AC Split Daikin 1.5 PK',
                'description' => 'Air conditioner untuk ruang meeting',
                'category_id' => 6, // AC & Pendingin
                'location_id' => 4, // Meeting Room A
                'serial_number' => 'DAIKIN15PK001',
                'model' => 'FTV35BXV14',
                'brand' => 'Daikin',
                'purchase_price' => 6500000.00,
                'purchase_date' => '2024-01-20',
                'warranty_expiry' => '2027-01-20',
                'status' => 'in_use',
                'condition' => 'excellent',
            ],
        ];

        foreach ($assets as $asset) {
            \App\Models\Asset::create($asset);
        }
    }
}
