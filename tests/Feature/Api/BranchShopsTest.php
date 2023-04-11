<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Shop;
use App\Models\Branch;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchShopsTest extends TestCase
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
    public function it_gets_branch_shops(): void
    {
        $branch = Branch::factory()->create();
        $shops = Shop::factory()
            ->count(2)
            ->create([
                'branch_id' => $branch->id,
            ]);

        $response = $this->getJson(route('api.branches.shops.index', $branch));

        $response->assertOk()->assertSee($shops[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_branch_shops(): void
    {
        $branch = Branch::factory()->create();
        $data = Shop::factory()
            ->make([
                'branch_id' => $branch->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.branches.shops.store', $branch),
            $data
        );

        $this->assertDatabaseHas('shops', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $shop = Shop::latest('id')->first();

        $this->assertEquals($branch->id, $shop->branch_id);
    }
}
