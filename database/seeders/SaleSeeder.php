<?php

namespace Database\Seeders;

use App\Models\Cashier;
use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<=200; $i++ ){
            $cashier = Cashier::where('sale_id', $i)->get();
            $tqty = $cashier->sum('qty');
            $tprice = $cashier->sum('subtotal');
            $date = fake()->dateTimeBetween('-4 week');
            Sale::factory()->create([
                'member_id' => null,
                'user_id' =>fake()->numberBetween(1, 2) ,
                'total_qty' => $tqty,
                'total_price' => $tprice,
                'disc' => 0,
                'bill' => $tprice,
                'receipt' =>$tprice,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
