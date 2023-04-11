<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Sale;

use App\Models\Shop;
use App\Models\Buyer;
use App\Models\Product;
use App\Models\ProductCode;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleControllerTest extends TestCase
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
    public function it_displays_index_view_with_sales(): void
    {
        $sales = Sale::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('sales.index'));

        $response
            ->assertOk()
            ->assertViewIs('backend.sales.index')
            ->assertViewHas('sales');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_sale(): void
    {
        $response = $this->get(route('sales.create'));

        $response->assertOk()->assertViewIs('backend.sales.create');
    }

    /**
     * @test
     */
    public function it_stores_the_sale(): void
    {
        $data = Sale::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('sales.store'), $data);

        $this->assertDatabaseHas('sales', $data);

        $sale = Sale::latest('id')->first();

        $response->assertRedirect(route('sales.edit', $sale));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_sale(): void
    {
        $sale = Sale::factory()->create();

        $response = $this->get(route('sales.show', $sale));

        $response
            ->assertOk()
            ->assertViewIs('backend.sales.show')
            ->assertViewHas('sale');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_sale(): void
    {
        $sale = Sale::factory()->create();

        $response = $this->get(route('sales.edit', $sale));

        $response
            ->assertOk()
            ->assertViewIs('backend.sales.edit')
            ->assertViewHas('sale');
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

        $response = $this->put(route('sales.update', $sale), $data);

        $data['id'] = $sale->id;

        $this->assertDatabaseHas('sales', $data);

        $response->assertRedirect(route('sales.edit', $sale));
    }

    /**
     * @test
     */
    public function it_deletes_the_sale(): void
    {
        $sale = Sale::factory()->create();

        $response = $this->delete(route('sales.destroy', $sale));

        $response->assertRedirect(route('sales.index'));

        $this->assertModelMissing($sale);
    }
}
