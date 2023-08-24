<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::factory()->create([
            'name' => 'Alat Tulis Kantor',
        ]);
        \App\Models\Category::factory()->create([
            'name' => 'Sembako',
        ]);
        \App\Models\Category::factory()->create([
            'name' => 'Jajanan',
        ]);
    }
}
