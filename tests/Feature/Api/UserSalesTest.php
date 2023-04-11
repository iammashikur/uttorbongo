<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Sale;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSalesTest extends TestCase
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
    public function it_gets_user_sales(): void
    {
        $user = User::factory()->create();
        $sales = Sale::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.sales.index', $user));

        $response->assertOk()->assertSee($sales[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_user_sales(): void
    {
        $user = User::factory()->create();
        $data = Sale::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.sales.store', $user),
            $data
        );

        $this->assertDatabaseHas('sales', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $sale = Sale::latest('id')->first();

        $this->assertEquals($user->id, $sale->user_id);
    }
}
