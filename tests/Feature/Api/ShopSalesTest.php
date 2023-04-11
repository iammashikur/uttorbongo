<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Shop;
use App\Models\Sale;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopSalesTest extends TestCase
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
    public function it_gets_shop_sales(): void
    {
        $shop = Shop::factory()->create();
        $sales = Sale::factory()
            ->count(2)
            ->create([
                'shop_id' => $shop->id,
            ]);

        $response = $this->getJson(route('api.shops.sales.index', $shop));

        $response->assertOk()->assertSee($sales[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_shop_sales(): void
    {
        $shop = Shop::factory()->create();
        $data = Sale::factory()
            ->make([
                'shop_id' => $shop->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.shops.sales.store', $shop),
            $data
        );

        $this->assertDatabaseHas('sales', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $sale = Sale::latest('id')->first();

        $this->assertEquals($shop->id, $sale->shop_id);
    }
}
