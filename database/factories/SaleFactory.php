<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'purchase_price' => $this->faker->randomNumber(1),
            'sale_price' => $this->faker->randomNumber(1),
            'product_code_id' => \App\Models\ProductCode::factory(),
            'product_id' => \App\Models\Product::factory(),
            'buyer_id' => \App\Models\Buyer::factory(),
            'user_id' => \App\Models\User::factory(),
            'shop_id' => \App\Models\Shop::factory(),
        ];
    }
}
