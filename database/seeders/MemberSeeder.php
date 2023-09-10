<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Member::factory()->create(
            [
                'code' => '00001',
                'name' => 'Member 1',
                'address' => 'Member Street.',
                'contact' => '+12345678',
            ]);
    }
}
