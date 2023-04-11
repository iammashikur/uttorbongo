<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Seller;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SellerControllerTest extends TestCase
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
    public function it_displays_index_view_with_sellers(): void
    {
        $sellers = Seller::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('sellers.index'));

        $response
            ->assertOk()
            ->assertViewIs('backend.sellers.index')
            ->assertViewHas('sellers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_seller(): void
    {
        $response = $this->get(route('sellers.create'));

        $response->assertOk()->assertViewIs('backend.sellers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_seller(): void
    {
        $data = Seller::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('sellers.store'), $data);

        $this->assertDatabaseHas('sellers', $data);

        $seller = Seller::latest('id')->first();

        $response->assertRedirect(route('sellers.edit', $seller));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_seller(): void
    {
        $seller = Seller::factory()->create();

        $response = $this->get(route('sellers.show', $seller));

        $response
            ->assertOk()
            ->assertViewIs('backend.sellers.show')
            ->assertViewHas('seller');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_seller(): void
    {
        $seller = Seller::factory()->create();

        $response = $this->get(route('sellers.edit', $seller));

        $response
            ->assertOk()
            ->assertViewIs('backend.sellers.edit')
            ->assertViewHas('seller');
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

        $response = $this->put(route('sellers.update', $seller), $data);

        $data['id'] = $seller->id;

        $this->assertDatabaseHas('sellers', $data);

        $response->assertRedirect(route('sellers.edit', $seller));
    }

    /**
     * @test
     */
    public function it_deletes_the_seller(): void
    {
        $seller = Seller::factory()->create();

        $response = $this->delete(route('sellers.destroy', $seller));

        $response->assertRedirect(route('sellers.index'));

        $this->assertModelMissing($seller);
    }
}
