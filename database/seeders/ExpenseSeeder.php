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
            'created_at' => date('Y-m-01'),
            'updated_at' => date('Y-m-01'),
        ]);
        Expense::factory()->create([
            'desc' => 'Pembayaran Air Toko',
            'nominal' => 300000,
            'created_at' => date('Y-m-01'),
            'updated_at' => date('Y-m-01'),
        ]);
        Expense::factory()->create([
            'desc' => 'Panas Gaes Hauzzs',
            'nominal' => 200000,
        ]);
    }
}
