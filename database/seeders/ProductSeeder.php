<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Product::factory()->create([
        //     'category_id' => 4,
        //     'code' => 'P0001',
        //     'name' => 'Buku Tulis 50 Lembar',
        //     'brand' => 'Kiki',
        //     'sell_price' => '7000',
        //     'disc' => '0'
        // ]);
        \App\Models\Product::factory()->create([
            'category_id' => 4,
            'code' => 'P0002',
            'name' => 'Pulpen Hitam Standard',
            'brand' => 'Standard',
            'sell_price' => '3000',
            'disc' => '0'
        ]);
        \App\Models\Product::factory()->create([
            'category_id' => 4,
            'code' => 'P0003',
            'name' => 'Pulpen Hitam Cair',
            'brand' => 'Kiki',
            'sell_price' => '5000',
            'disc' => '0'
        ]);
    }
}
