<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Brand;
use App\Models\Product;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrandProductsTest extends TestCase
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
    public function it_gets_brand_products(): void
    {
        $brand = Brand::factory()->create();
        $products = Product::factory()
            ->count(2)
            ->create([
                'brand_id' => $brand->id,
            ]);

        $response = $this->getJson(route('api.brands.products.index', $brand));

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_brand_products(): void
    {
        $brand = Brand::factory()->create();
        $data = Product::factory()
            ->make([
                'brand_id' => $brand->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.brands.products.store', $brand),
            $data
        );

        unset($data['shop_id']);

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $product = Product::latest('id')->first();

        $this->assertEquals($brand->id, $product->brand_id);
    }
}
