<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Shop;

use App\Models\Branch;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopControllerTest extends TestCase
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
    public function it_displays_index_view_with_shops(): void
    {
        $shops = Shop::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('shops.index'));

        $response
            ->assertOk()
            ->assertViewIs('backend.shops.index')
            ->assertViewHas('shops');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_shop(): void
    {
        $response = $this->get(route('shops.create'));

        $response->assertOk()->assertViewIs('backend.shops.create');
    }

    /**
     * @test
     */
    public function it_stores_the_shop(): void
    {
        $data = Shop::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('shops.store'), $data);

        $this->assertDatabaseHas('shops', $data);

        $shop = Shop::latest('id')->first();

        $response->assertRedirect(route('shops.edit', $shop));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_shop(): void
    {
        $shop = Shop::factory()->create();

        $response = $this->get(route('shops.show', $shop));

        $response
            ->assertOk()
            ->assertViewIs('backend.shops.show')
            ->assertViewHas('shop');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_shop(): void
    {
        $shop = Shop::factory()->create();

        $response = $this->get(route('shops.edit', $shop));

        $response
            ->assertOk()
            ->assertViewIs('backend.shops.edit')
            ->assertViewHas('shop');
    }

    /**
     * @test
     */
    public function it_updates_the_shop(): void
    {
        $shop = Shop::factory()->create();

        $branch = Branch::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'address' => $this->faker->address,
            'branch_id' => $branch->id,
        ];

        $response = $this->put(route('shops.update', $shop), $data);

        $data['id'] = $shop->id;

        $this->assertDatabaseHas('shops', $data);

        $response->assertRedirect(route('shops.edit', $shop));
    }

    /**
     * @test
     */
    public function it_deletes_the_shop(): void
    {
        $shop = Shop::factory()->create();

        $response = $this->delete(route('shops.destroy', $shop));

        $response->assertRedirect(route('shops.index'));

        $this->assertModelMissing($shop);
    }
}
