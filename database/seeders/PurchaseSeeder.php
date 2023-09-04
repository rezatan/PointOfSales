<?php

namespace Database\Seeders;

use App\Models\Purchase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Purchase::factory()->create([
            'supplier_id' => 1,
            'total_qty' => 300,
            'total_price' => 1100000,
            'disc' => '0',
            'payment' => 1100000,
        ]);
    }
}
