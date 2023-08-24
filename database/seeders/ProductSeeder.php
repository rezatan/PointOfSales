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
            'name' => 'Buku Tulis 50 Lembar',
            'brand' => 'Kiki',
        ]);
        Product::factory()->create([
            'category_id' => 1,
            'name' => 'Pulpen Hitam Standard',
            'brand' => 'Standard',
        ]);
        Product::factory()->create([
            'category_id' => 2,
            'name' => 'Minyak Goreng Filma 1KG',
            'brand' => 'Filma',
        ]);
        Product::factory()->create(
        [
            'category_id' => 3,
            'name' => 'Kerupuk Sambal',
            'brand' => '',
        ]);
    }
}
