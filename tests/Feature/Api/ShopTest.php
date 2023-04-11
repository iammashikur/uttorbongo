<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Shop;

use App\Models\Branch;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopTest extends TestCase
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
    public function it_gets_shops_list(): void
    {
        $shops = Shop::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.shops.index'));

        $response->assertOk()->assertSee($shops[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_shop(): void
    {
        $data = Shop::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.shops.store'), $data);

        $this->assertDatabaseHas('shops', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.shops.update', $shop), $data);

        $data['id'] = $shop->id;

        $this->assertDatabaseHas('shops', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_shop(): void
    {
        $shop = Shop::factory()->create();

        $response = $this->deleteJson(route('api.shops.destroy', $shop));

        $this->assertModelMissing($shop);

        $response->assertNoContent();
    }
}
