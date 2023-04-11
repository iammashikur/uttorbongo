<?php

namespace Database\Factories;

use App\Models\Seller;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SellerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Seller::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'document' => $this->faker->text(255),
        ];
    }
}
