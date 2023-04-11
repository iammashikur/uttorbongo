<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ProductCategory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductCategoryControllerTest extends TestCase
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
    public function it_displays_index_view_with_product_categories(): void
    {
        $productCategories = ProductCategory::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('product-categories.index'));

        $response
            ->assertOk()
            ->assertViewIs('backend.product_categories.index')
            ->assertViewHas('productCategories');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_product_category(): void
    {
        $response = $this->get(route('product-categories.create'));

        $response
            ->assertOk()
            ->assertViewIs('backend.product_categories.create');
    }

    /**
     * @test
     */
    public function it_stores_the_product_category(): void
    {
        $data = ProductCategory::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('product-categories.store'), $data);

        $this->assertDatabaseHas('product_categories', $data);

        $productCategory = ProductCategory::latest('id')->first();

        $response->assertRedirect(
            route('product-categories.edit', $productCategory)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_product_category(): void
    {
        $productCategory = ProductCategory::factory()->create();

        $response = $this->get(
            route('product-categories.show', $productCategory)
        );

        $response
            ->assertOk()
            ->assertViewIs('backend.product_categories.show')
            ->assertViewHas('productCategory');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_product_category(): void
    {
        $productCategory = ProductCategory::factory()->create();

        $response = $this->get(
            route('product-categories.edit', $productCategory)
        );

        $response
            ->assertOk()
            ->assertViewIs('backend.product_categories.edit')
            ->assertViewHas('productCategory');
    }

    /**
     * @test
     */
    public function it_updates_the_product_category(): void
    {
        $productCategory = ProductCategory::factory()->create();

        $data = [
            'name' => $this->faker->name(),
        ];

        $response = $this->put(
            route('product-categories.update', $productCategory),
            $data
        );

        $data['id'] = $productCategory->id;

        $this->assertDatabaseHas('product_categories', $data);

        $response->assertRedirect(
            route('product-categories.edit', $productCategory)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_product_category(): void
    {
        $productCategory = ProductCategory::factory()->create();

        $response = $this->delete(
            route('product-categories.destroy', $productCategory)
        );

        $response->assertRedirect(route('product-categories.index'));

        $this->assertModelMissing($productCategory);
    }
}
