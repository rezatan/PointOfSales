<?php

namespace Database\Seeders;

use App\Models\PurchaseDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PurchaseDetails::factory()->create([
            'purchase_id' => 1,
            'stock_id' => 1,
            'buy_price' => 4000,
            'qty' => 100,
            'subtotal' => 400000,
        ]);
        PurchaseDetails::factory()->create([
            'purchase_id' => 1,
            'stock_id' => 5,
            'buy_price' => 3500,
            'qty' => 200,
            'subtotal' => 700000,
        ]);
    }
}
