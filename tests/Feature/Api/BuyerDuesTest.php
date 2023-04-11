<?php

namespace Tests\Feature\Api;

use App\Models\Due;
use App\Models\User;
use App\Models\Buyer;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuyerDuesTest extends TestCase
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
    public function it_gets_buyer_dues(): void
    {
        $buyer = Buyer::factory()->create();
        $dues = Due::factory()
            ->count(2)
            ->create([
                'buyer_id' => $buyer->id,
            ]);

        $response = $this->getJson(route('api.buyers.dues.index', $buyer));

        $response->assertOk()->assertSee($dues[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_buyer_dues(): void
    {
        $buyer = Buyer::factory()->create();
        $data = Due::factory()
            ->make([
                'buyer_id' => $buyer->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.buyers.dues.store', $buyer),
            $data
        );

        $this->assertDatabaseHas('dues', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $due = Due::latest('id')->first();

        $this->assertEquals($buyer->id, $due->buyer_id);
    }
}
