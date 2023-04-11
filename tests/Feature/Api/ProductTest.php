<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;

use App\Models\Brand;
use App\Models\Seller;
use App\Models\Supplier;
use App\Models\ProductCategory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_products_list(): void
    {
        $products = Product::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.products.index'));

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_product(): void
    {
        $data = Product::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.products.store'), $data);

        unset($data['shop_id']);

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_product(): void
    {
        $product = Product::factory()->create();

        $productCategory = ProductCategory::factory()->create();
        $supplier = Supplier::factory()->create();
        $seller = Seller::factory()->create();
        $brand = Brand::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'image' => $this->faker->text(255),
            'shop_id' => $this->faker->randomNumber,
            'purchase_price' => $this->faker->randomFloat(2, 0, 9999),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'details' => $this->faker->sentence(20),
            'product_type' => $this->faker->text(255),
            'show_on_website' => $this->faker->boolean,
            'product_category_id' => $productCategory->id,
            'supplier_id' => $supplier->id,
            'seller_id' => $seller->id,
            'brand_id' => $brand->id,
        ];

        $response = $this->putJson(
            route('api.products.update', $product),
            $data
        );

        unset($data['shop_id']);

        $data['id'] = $product->id;

        $this->assertDatabaseHas('products', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(route('api.products.destroy', $product));

        $this->assertModelMissing($product);

        $response->assertNoContent();
    }
}
