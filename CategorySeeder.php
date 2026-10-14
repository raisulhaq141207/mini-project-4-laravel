<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Elektronik', 'description' => 'Perangkat dan aksesoris elektronik'],
            ['name' => 'Alat Tulis', 'description' => 'Perlengkapan tulis dan kantor'],
            ['name' => 'Peralatan Rumah Tangga', 'description' => 'Barang kebutuhan rumah tangga'],
            ['name' => 'Makanan & Minuman', 'description' => 'Produk konsumsi kemasan'],
        ];

        foreach ($data as $row) {
            Category::updateOrCreate(['name' => $row['name']], $row);
        }
    }
}
