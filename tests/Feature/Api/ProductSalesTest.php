<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Sale;
use App\Models\Product;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductSalesTest extends TestCase
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
    public function it_gets_product_sales(): void
    {
        $product = Product::factory()->create();
        $sales = Sale::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(route('api.products.sales.index', $product));

        $response->assertOk()->assertSee($sales[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_product_sales(): void
    {
        $product = Product::factory()->create();
        $data = Sale::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.sales.store', $product),
            $data
        );

        $this->assertDatabaseHas('sales', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $sale = Sale::latest('id')->first();

        $this->assertEquals($product->id, $sale->product_id);
    }
}
