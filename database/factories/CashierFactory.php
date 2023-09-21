<?php

namespace Database\Factories;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cashier>
 */
class CashierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stockId = fake()->numberBetween(1, 6);
        $stock = Stock::find($stockId);
        $sellPrice = $stock->sell_price;
        $qty = fake()->numberBetween(1, 3);
        $disc = $stock->disc;
        $subtotal = $sellPrice * $qty;
        if($disc !=0){
            $subtotal = $subtotal - ($subtotal * $disc / 100);
        }
        $date = fake()->dateTimeBetween('-4 week', '+4 week');
        $stock->qty -= $qty;
        $stock->save();
        return [
            'sale_id' => fake()->numberBetween(1, 150),
            'stock_id' => $stockId,
            'sell_price' => $sellPrice,
            'qty' => $qty,
            'disc' => $disc,
            'subtotal' => $subtotal,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
