<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'PT Sumber Makmur', 'phone' => '0651-7001001', 'email' => 'sales@sumbermakmur.test', 'address' => 'Banda Aceh'],
            ['name' => 'CV Aceh Jaya Abadi', 'phone' => '0651-7002002', 'email' => 'info@acehjaya.test', 'address' => 'Lhokseumawe'],
            ['name' => 'UD Barokah', 'phone' => '0812-0000-1234', 'email' => 'barokah@example.test', 'address' => 'Medan'],
        ];

        foreach ($data as $row) {
            Supplier::updateOrCreate(['name' => $row['name']], $row);
        }
    }
}
