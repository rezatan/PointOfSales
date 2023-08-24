<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Stock;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stock::factory()->create([
            'product_id' => 1,
            'supplier_id' => 1,
            'code' => 'P000001',
            'qty' => 100,
            'buy_price' => 4000,
            'sell_price' => 5000,
            'disc' => '0',
        ]);
        Stock::factory()->create([
            'product_id' => 2,
            'supplier_id' => 3,
            'code' => 'P000002',
            'qty' => 200,
            'buy_price' => 2000,
            'sell_price' => 3000,
            'disc' => '0',
        ]);
        Stock::factory()->create([
            'product_id' => 3,
            'supplier_id' => 2,
            'code' => 'P000003',
            'qty' => 50,
            'buy_price' => 15000,
            'sell_price' => 20000,
            'disc' => '10',
        ]);
        Stock::factory()->create([
            'product_id' => 4,
            'supplier_id' => 4,
            'code' => 'P000004',
            'qty' => 500,
            'buy_price' => 800,
            'sell_price' => 1000,
            'disc' => '0',
        ]);
    }
}
