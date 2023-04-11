<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Seller;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SellerTest extends TestCase
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
    public function it_gets_sellers_list(): void
    {
        $sellers = Seller::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.sellers.index'));

        $response->assertOk()->assertSee($sellers[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_seller(): void
    {
        $data = Seller::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.sellers.store'), $data);

        $this->assertDatabaseHas('sellers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_seller(): void
    {
        $seller = Seller::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'document' => $this->faker->text(255),
        ];

        $response = $this->putJson(route('api.sellers.update', $seller), $data);

        $data['id'] = $seller->id;

        $this->assertDatabaseHas('sellers', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_seller(): void
    {
        $seller = Seller::factory()->create();

        $response = $this->deleteJson(route('api.sellers.destroy', $seller));

        $this->assertModelMissing($seller);

        $response->assertNoContent();
    }
}
