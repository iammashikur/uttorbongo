<?php

namespace Tests\Feature\Api;

use App\Models\Due;
use App\Models\User;

use App\Models\Buyer;
use App\Models\Product;
use App\Models\ProductCode;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DueTest extends TestCase
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
    public function it_gets_dues_list(): void
    {
        $dues = Due::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.dues.index'));

        $response->assertOk()->assertSee($dues[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_due(): void
    {
        $data = Due::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.dues.store'), $data);

        $this->assertDatabaseHas('dues', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_due(): void
    {
        $due = Due::factory()->create();

        $buyer = Buyer::factory()->create();
        $product = Product::factory()->create();
        $productCode = ProductCode::factory()->create();
        $user = User::factory()->create();

        $data = [
            'due_amount' => $this->faker->randomNumber(1),
            'buyer_id' => $buyer->id,
            'product_id' => $product->id,
            'product_code_id' => $productCode->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(route('api.dues.update', $due), $data);

        $data['id'] = $due->id;

        $this->assertDatabaseHas('dues', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_due(): void
    {
        $due = Due::factory()->create();

        $response = $this->deleteJson(route('api.dues.destroy', $due));

        $this->assertModelMissing($due);

        $response->assertNoContent();
    }
}
