<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test Admin',
            'username' => 'testadmin',
            'email' => 'testadmin@gmail.com',
            'password' => bcrypt(123456789),
            'level' => 1
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test Cashier',
            'username' => 'testcashier',
            'email' => 'testcashier@gmail.com',
            'password' => bcrypt(123456789),
            'level' => 2
        ]);
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            SupplierSeeder::class,
            StockSeeder::class,
            ExpenseSeeder::class,
            PurchaseSeeder::class,
            PurchaseDetailsSeeder::class,
            ShopSeeder::class,
        ]);
    }
}
