<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use  \App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->create([
            'category_id' => 1,
            'code' => 'P00001',
            'name' => 'Buku Tulis 50 Lembar',
            'brand' => 'Kiky',
        ]);
        Product::factory()->create([
            'category_id' => 1,
            'code' => 'P00002',
            'name' => 'Pulpen Hitam Standard',
            'brand' => 'Standard',
        ]);
        Product::factory()->create([
            'category_id' => 2,
            'code' => 'P00003',
            'name' => 'Minyak Goreng Filma 1KG',
            'brand' => 'Filma',
        ]);
        Product::factory()->create(
        [
            'category_id' => 3,
            'code' => 'P00004',
            'name' => 'Kerupuk Sambal',
            'brand' => '',
        ]);
        Product::factory()->create([
            'category_id' => 1,
            'code' => 'P00005',
            'name' => 'Pulpen Hitam Kiky',
            'brand' => 'Kiky',
        ]);
    }
}
