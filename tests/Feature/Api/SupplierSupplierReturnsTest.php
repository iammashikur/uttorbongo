<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Supplier;
use App\Models\SupplierReturn;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierSupplierReturnsTest extends TestCase
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
    public function it_gets_supplier_supplier_returns(): void
    {
        $supplier = Supplier::factory()->create();
        $supplierReturns = SupplierReturn::factory()
            ->count(2)
            ->create([
                'supplier_id' => $supplier->id,
            ]);

        $response = $this->getJson(
            route('api.suppliers.supplier-returns.index', $supplier)
        );

        $response->assertOk()->assertSee($supplierReturns[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_supplier_supplier_returns(): void
    {
        $supplier = Supplier::factory()->create();
        $data = SupplierReturn::factory()
            ->make([
                'supplier_id' => $supplier->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.suppliers.supplier-returns.store', $supplier),
            $data
        );

        $this->assertDatabaseHas('supplier_returns', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $supplierReturn = SupplierReturn::latest('id')->first();

        $this->assertEquals($supplier->id, $supplierReturn->supplier_id);
    }
}
