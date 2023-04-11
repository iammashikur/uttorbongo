<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Supplier;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierTest extends TestCase
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
    public function it_gets_suppliers_list(): void
    {
        $suppliers = Supplier::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.suppliers.index'));

        $response->assertOk()->assertSee($suppliers[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_supplier(): void
    {
        $data = Supplier::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.suppliers.store'), $data);

        $this->assertDatabaseHas('suppliers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_supplier(): void
    {
        $supplier = Supplier::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
        ];

        $response = $this->putJson(
            route('api.suppliers.update', $supplier),
            $data
        );

        $data['id'] = $supplier->id;

        $this->assertDatabaseHas('suppliers', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_supplier(): void
    {
        $supplier = Supplier::factory()->create();

        $response = $this->deleteJson(
            route('api.suppliers.destroy', $supplier)
        );

        $this->assertModelMissing($supplier);

        $response->assertNoContent();
    }
}
