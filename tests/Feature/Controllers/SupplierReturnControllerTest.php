<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SupplierReturn;

use App\Models\Product;
use App\Models\Supplier;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierReturnControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_supplier_returns(): void
    {
        $supplierReturns = SupplierReturn::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('supplier-returns.index'));

        $response
            ->assertOk()
            ->assertViewIs('backend.supplier_returns.index')
            ->assertViewHas('supplierReturns');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_supplier_return(): void
    {
        $response = $this->get(route('supplier-returns.create'));

        $response->assertOk()->assertViewIs('backend.supplier_returns.create');
    }

    /**
     * @test
     */
    public function it_stores_the_supplier_return(): void
    {
        $data = SupplierReturn::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('supplier-returns.store'), $data);

        $this->assertDatabaseHas('supplier_returns', $data);

        $supplierReturn = SupplierReturn::latest('id')->first();

        $response->assertRedirect(
            route('supplier-returns.edit', $supplierReturn)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_supplier_return(): void
    {
        $supplierReturn = SupplierReturn::factory()->create();

        $response = $this->get(route('supplier-returns.show', $supplierReturn));

        $response
            ->assertOk()
            ->assertViewIs('backend.supplier_returns.show')
            ->assertViewHas('supplierReturn');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_supplier_return(): void
    {
        $supplierReturn = SupplierReturn::factory()->create();

        $response = $this->get(route('supplier-returns.edit', $supplierReturn));

        $response
            ->assertOk()
            ->assertViewIs('backend.supplier_returns.edit')
            ->assertViewHas('supplierReturn');
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

        $response = $this->put(
            route('supplier-returns.update', $supplierReturn),
            $data
        );

        $data['id'] = $supplierReturn->id;

        $this->assertDatabaseHas('supplier_returns', $data);

        $response->assertRedirect(
            route('supplier-returns.edit', $supplierReturn)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_supplier_return(): void
    {
        $supplierReturn = SupplierReturn::factory()->create();

        $response = $this->delete(
            route('supplier-returns.destroy', $supplierReturn)
        );

        $response->assertRedirect(route('supplier-returns.index'));

        $this->assertModelMissing($supplierReturn);
    }
}
