<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Category::pluck('id', 'name');
        $sup = Supplier::pluck('id', 'name');

        $data = [
            ['ELK-001', 'Mouse Wireless', 'Elektronik', 'PT Sumber Makmur', 85000, 40, 10],
            ['ELK-002', 'Keyboard Mekanik', 'Elektronik', 'PT Sumber Makmur', 350000, 15, 5],
            ['ELK-003', 'Flashdisk 64GB', 'Elektronik', 'CV Aceh Jaya Abadi', 70000, 3, 10],
            ['ATK-001', 'Pulpen Hitam (box)', 'Alat Tulis', 'UD Barokah', 25000, 120, 20],
            ['ATK-002', 'Buku Tulis A5', 'Alat Tulis', 'UD Barokah', 6000, 200, 50],
            ['RT-001', 'Gelas Kaca Set 6', 'Peralatan Rumah Tangga', 'CV Aceh Jaya Abadi', 55000, 25, 8],
            ['MNM-001', 'Air Mineral 600ml (dus)', 'Makanan & Minuman', 'UD Barokah', 48000, 4, 10],
            ['MNM-002', 'Kopi Sachet (renceng)', 'Makanan & Minuman', 'CV Aceh Jaya Abadi', 14000, 60, 15],
        ];

        foreach ($data as [$sku, $name, $category, $supplier, $price, $stock, $min]) {
            Product::updateOrCreate(['sku' => $sku], [
                'name' => $name,
                'category_id' => $cat[$category],
                'supplier_id' => $sup[$supplier],
                'price' => $price,
                'stock' => $stock,
                'min_stock' => $min,
                'description' => "Data contoh: {$name}",
            ]);
        }
    }
}
