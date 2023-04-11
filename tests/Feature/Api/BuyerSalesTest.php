<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Sale;
use App\Models\Buyer;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuyerSalesTest extends TestCase
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
    public function it_gets_buyer_sales(): void
    {
        $buyer = Buyer::factory()->create();
        $sales = Sale::factory()
            ->count(2)
            ->create([
                'buyer_id' => $buyer->id,
            ]);

        $response = $this->getJson(route('api.buyers.sales.index', $buyer));

        $response->assertOk()->assertSee($sales[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_buyer_sales(): void
    {
        $buyer = Buyer::factory()->create();
        $data = Sale::factory()
            ->make([
                'buyer_id' => $buyer->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.buyers.sales.store', $buyer),
            $data
        );

        $this->assertDatabaseHas('sales', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $sale = Sale::latest('id')->first();

        $this->assertEquals($buyer->id, $sale->buyer_id);
    }
}
