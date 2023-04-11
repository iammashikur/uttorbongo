<?php

namespace Tests\Feature\Controllers;

use App\Models\Due;
use App\Models\User;

use App\Models\Buyer;
use App\Models\Product;
use App\Models\ProductCode;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DueControllerTest extends TestCase
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
    public function it_displays_index_view_with_dues(): void
    {
        $dues = Due::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('dues.index'));

        $response
            ->assertOk()
            ->assertViewIs('backend.dues.index')
            ->assertViewHas('dues');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_due(): void
    {
        $response = $this->get(route('dues.create'));

        $response->assertOk()->assertViewIs('backend.dues.create');
    }

    /**
     * @test
     */
    public function it_stores_the_due(): void
    {
        $data = Due::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('dues.store'), $data);

        $this->assertDatabaseHas('dues', $data);

        $due = Due::latest('id')->first();

        $response->assertRedirect(route('dues.edit', $due));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_due(): void
    {
        $due = Due::factory()->create();

        $response = $this->get(route('dues.show', $due));

        $response
            ->assertOk()
            ->assertViewIs('backend.dues.show')
            ->assertViewHas('due');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_due(): void
    {
        $due = Due::factory()->create();

        $response = $this->get(route('dues.edit', $due));

        $response
            ->assertOk()
            ->assertViewIs('backend.dues.edit')
            ->assertViewHas('due');
    }

    /**
     * @test
     */
    public function it_updates_the_due(): void
    {
        $due = Due::factory()->create();

        $buyer = Buyer::factory()->create();
        $product = Product::factory()->create();
        $productCode = ProductCode::factory()->create();
        $user = User::factory()->create();

        $data = [
            'due_amount' => $this->faker->randomNumber(1),
            'buyer_id' => $buyer->id,
            'product_id' => $product->id,
            'product_code_id' => $productCode->id,
            'user_id' => $user->id,
        ];

        $response = $this->put(route('dues.update', $due), $data);

        $data['id'] = $due->id;

        $this->assertDatabaseHas('dues', $data);

        $response->assertRedirect(route('dues.edit', $due));
    }

    /**
     * @test
     */
    public function it_deletes_the_due(): void
    {
        $due = Due::factory()->create();

        $response = $this->delete(route('dues.destroy', $due));

        $response->assertRedirect(route('dues.index'));

        $this->assertModelMissing($due);
    }
}
