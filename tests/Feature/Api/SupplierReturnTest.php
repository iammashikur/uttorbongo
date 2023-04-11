<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SupplierReturn;

use App\Models\Product;
use App\Models\Supplier;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierReturnTest extends TestCase
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
    public function it_gets_supplier_returns_list(): void
    {
        $supplierReturns = SupplierReturn::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.supplier-returns.index'));

        $response->assertOk()->assertSee($supplierReturns[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_supplier_return(): void
    {
        $data = SupplierReturn::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.supplier-returns.store'), $data);

        $this->assertDatabaseHas('supplier_returns', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_supplier_return(): void
    {
        $supplierReturn = SupplierReturn::factory()->create();

        $supplier = Supplier::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'supplier_id' => $supplier->id,
            'product_id' => $product->id,
        ];

        $response = $this->putJson(
            route('api.supplier-returns.update', $supplierReturn),
            $data
        );

        $data['id'] = $supplierReturn->id;

        $this->assertDatabaseHas('supplier_returns', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_supplier_return(): void
    {
        $supplierReturn = SupplierReturn::factory()->create();

        $response = $this->deleteJson(
            route('api.supplier-returns.destroy', $supplierReturn)
        );

        $this->assertModelMissing($supplierReturn);

        $response->assertNoContent();
    }
}
