<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Brand;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrandControllerTest extends TestCase
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
    public function it_displays_index_view_with_brands(): void
    {
        $brands = Brand::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('brands.index'));

        $response
            ->assertOk()
            ->assertViewIs('backend.brands.index')
            ->assertViewHas('brands');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_brand(): void
    {
        $response = $this->get(route('brands.create'));

        $response->assertOk()->assertViewIs('backend.brands.create');
    }

    /**
     * @test
     */
    public function it_stores_the_brand(): void
    {
        $data = Brand::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('brands.store'), $data);

        $this->assertDatabaseHas('brands', $data);

        $brand = Brand::latest('id')->first();

        $response->assertRedirect(route('brands.edit', $brand));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_brand(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->get(route('brands.show', $brand));

        $response
            ->assertOk()
            ->assertViewIs('backend.brands.show')
            ->assertViewHas('brand');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_brand(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->get(route('brands.edit', $brand));

        $response
            ->assertOk()
            ->assertViewIs('backend.brands.edit')
            ->assertViewHas('brand');
    }

    /**
     * @test
     */
    public function it_updates_the_brand(): void
    {
        $brand = Brand::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'logo' => $this->faker->text(255),
        ];

        $response = $this->put(route('brands.update', $brand), $data);

        $data['id'] = $brand->id;

        $this->assertDatabaseHas('brands', $data);

        $response->assertRedirect(route('brands.edit', $brand));
    }

    /**
     * @test
     */
    public function it_deletes_the_brand(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->delete(route('brands.destroy', $brand));

        $response->assertRedirect(route('brands.index'));

        $this->assertModelMissing($brand);
    }
}
