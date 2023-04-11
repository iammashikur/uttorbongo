<?php

namespace Tests\Feature\Api;

use App\Models\Due;
use App\Models\User;
use App\Models\Product;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductDuesTest extends TestCase
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
    public function it_gets_product_dues(): void
    {
        $product = Product::factory()->create();
        $dues = Due::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(route('api.products.dues.index', $product));

        $response->assertOk()->assertSee($dues[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_product_dues(): void
    {
        $product = Product::factory()->create();
        $data = Due::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.dues.store', $product),
            $data
        );

        $this->assertDatabaseHas('dues', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $due = Due::latest('id')->first();

        $this->assertEquals($product->id, $due->product_id);
    }
}
