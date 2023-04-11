<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'image' => $this->faker->text(255),
            'shop_id' => $this->faker->randomNumber,
            'purchase_price' => $this->faker->randomFloat(2, 0, 9999),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'details' => $this->faker->sentence(20),
            'product_type' => $this->faker->text(255),
            'show_on_website' => $this->faker->boolean,
            'product_category_id' => \App\Models\ProductCategory::factory(),
            'supplier_id' => \App\Models\Supplier::factory(),
            'seller_id' => \App\Models\Seller::factory(),
            'brand_id' => \App\Models\Brand::factory(),
        ];
    }
}
