<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shop::factory()->create([
            'name' => 'Test Shop',
            'address' => 'In Some Places street',
            'contact' => '+123456789',
            'bill_type' => 1, //small
            'logo_path' => '/img/logo.png',
            'member_card_path' => '/img/member.png',
            'disc' => '5',
        ]);
    }
}
