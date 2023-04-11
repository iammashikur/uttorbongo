<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Brand;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrandTest extends TestCase
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
    public function it_gets_brands_list(): void
    {
        $brands = Brand::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.brands.index'));

        $response->assertOk()->assertSee($brands[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_brand(): void
    {
        $data = Brand::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.brands.store'), $data);

        $this->assertDatabaseHas('brands', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.brands.update', $brand), $data);

        $data['id'] = $brand->id;

        $this->assertDatabaseHas('brands', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_brand(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->deleteJson(route('api.brands.destroy', $brand));

        $this->assertModelMissing($brand);

        $response->assertNoContent();
    }
}
