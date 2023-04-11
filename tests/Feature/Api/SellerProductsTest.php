<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Seller;
use App\Models\Product;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SellerProductsTest extends TestCase
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
    public function it_gets_seller_products(): void
    {
        $seller = Seller::factory()->create();
        $products = Product::factory()
            ->count(2)
            ->create([
                'seller_id' => $seller->id,
            ]);

        $response = $this->getJson(
            route('api.sellers.products.index', $seller)
        );

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_seller_products(): void
    {
        $seller = Seller::factory()->create();
        $data = Product::factory()
            ->make([
                'seller_id' => $seller->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.sellers.products.store', $seller),
            $data
        );

        unset($data['shop_id']);

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $product = Product::latest('id')->first();

        $this->assertEquals($seller->id, $product->seller_id);
    }
}
