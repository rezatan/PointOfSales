<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use \App\Models\Expense;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Expense::factory()->create([
            'desc' => 'Pembayaran Listrik Toko',
            'nominal' => 500000,
        ]);
        Expense::factory()->create([
            'desc' => 'Pembayaran Air Toko',
            'nominal' => 300000,
        ]);
        Expense::factory()->create([
            'desc' => 'Jajan Bersama',
            'nominal' => 200000,
        ]);
    }
}
