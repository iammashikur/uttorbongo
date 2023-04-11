<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\SupplierReturn;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductSupplierReturnsTest extends TestCase
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
    public function it_gets_product_supplier_returns(): void
    {
        $product = Product::factory()->create();
        $supplierReturns = SupplierReturn::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.supplier-returns.index', $product)
        );

        $response->assertOk()->assertSee($supplierReturns[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_product_supplier_returns(): void
    {
        $product = Product::factory()->create();
        $data = SupplierReturn::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.supplier-returns.store', $product),
            $data
        );

        $this->assertDatabaseHas('supplier_returns', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $supplierReturn = SupplierReturn::latest('id')->first();

        $this->assertEquals($product->id, $supplierReturn->product_id);
    }
}
