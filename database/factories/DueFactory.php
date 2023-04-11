<?php

namespace Database\Factories;

use App\Models\Due;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Due::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'due_amount' => $this->faker->randomNumber(1),
            'buyer_id' => \App\Models\Buyer::factory(),
            'product_id' => \App\Models\Product::factory(),
            'product_code_id' => \App\Models\ProductCode::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
