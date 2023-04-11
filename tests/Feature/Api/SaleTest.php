<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Sale;

use App\Models\Shop;
use App\Models\Buyer;
use App\Models\Product;
use App\Models\ProductCode;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleTest extends TestCase
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
    public function it_gets_sales_list(): void
    {
        $sales = Sale::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.sales.index'));

        $response->assertOk()->assertSee($sales[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_sale(): void
    {
        $data = Sale::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.sales.store'), $data);

        $this->assertDatabaseHas('sales', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_sale(): void
    {
        $sale = Sale::factory()->create();

        $productCode = ProductCode::factory()->create();
        $product = Product::factory()->create();
        $buyer = Buyer::factory()->create();
        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        $data = [
            'purchase_price' => $this->faker->randomNumber(1),
            'sale_price' => $this->faker->randomNumber(1),
            'product_code_id' => $productCode->id,
            'product_id' => $product->id,
            'buyer_id' => $buyer->id,
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ];

        $response = $this->putJson(route('api.sales.update', $sale), $data);

        $data['id'] = $sale->id;

        $this->assertDatabaseHas('sales', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_sale(): void
    {
        $sale = Sale::factory()->create();

        $response = $this->deleteJson(route('api.sales.destroy', $sale));

        $this->assertModelMissing($sale);

        $response->assertNoContent();
    }
}
