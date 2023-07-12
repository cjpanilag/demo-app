<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $quantity = mt_rand(1, 20);
        $rand_date = $this->faker->dateTimeBetween($startDate = '-1 month', $endDate = 'now');
        $tax = Tax::select(DB::raw("CAST((CAST(value as DECIMAL(10,2))/100) as DECIMAL(10,2)) as tax_value"))->first();

        $product = Product::select(
            DB::raw(
                "CAST((CAST(price as DECIMAL(10,2)) + (CAST(price as DECIMAL(10,2)) * CAST({$tax->tax_value} as DECIMAL(10,2))))
                  * $quantity as DECIMAL(10,2)) as total_amount"
            ),
            'id'
        )->get()->random();

        return [
            'product_id' => $product->id,
            'quantity' => $quantity,
            'total_amount' => $product->total_amount,
            'tax_id' => Tax::first()->id,
            'created_at' => $rand_date,
            'updated_at' => $rand_date,
        ];
    }
}
