<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Buyer;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuyerControllerTest extends TestCase
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
    public function it_displays_index_view_with_buyers(): void
    {
        $buyers = Buyer::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('buyers.index'));

        $response
            ->assertOk()
            ->assertViewIs('backend.buyers.index')
            ->assertViewHas('buyers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_buyer(): void
    {
        $response = $this->get(route('buyers.create'));

        $response->assertOk()->assertViewIs('backend.buyers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_buyer(): void
    {
        $data = Buyer::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('buyers.store'), $data);

        $this->assertDatabaseHas('buyers', $data);

        $buyer = Buyer::latest('id')->first();

        $response->assertRedirect(route('buyers.edit', $buyer));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_buyer(): void
    {
        $buyer = Buyer::factory()->create();

        $response = $this->get(route('buyers.show', $buyer));

        $response
            ->assertOk()
            ->assertViewIs('backend.buyers.show')
            ->assertViewHas('buyer');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_buyer(): void
    {
        $buyer = Buyer::factory()->create();

        $response = $this->get(route('buyers.edit', $buyer));

        $response
            ->assertOk()
            ->assertViewIs('backend.buyers.edit')
            ->assertViewHas('buyer');
    }

    /**
     * @test
     */
    public function it_updates_the_buyer(): void
    {
        $buyer = Buyer::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
        ];

        $response = $this->put(route('buyers.update', $buyer), $data);

        $data['id'] = $buyer->id;

        $this->assertDatabaseHas('buyers', $data);

        $response->assertRedirect(route('buyers.edit', $buyer));
    }

    /**
     * @test
     */
    public function it_deletes_the_buyer(): void
    {
        $buyer = Buyer::factory()->create();

        $response = $this->delete(route('buyers.destroy', $buyer));

        $response->assertRedirect(route('buyers.index'));

        $this->assertModelMissing($buyer);
    }
}
