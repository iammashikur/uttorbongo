<?php

namespace Tests\Feature\Api;

use App\Models\Due;
use App\Models\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserDuesTest extends TestCase
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
    public function it_gets_user_dues(): void
    {
        $user = User::factory()->create();
        $dues = Due::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.dues.index', $user));

        $response->assertOk()->assertSee($dues[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_user_dues(): void
    {
        $user = User::factory()->create();
        $data = Due::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.dues.store', $user),
            $data
        );

        $this->assertDatabaseHas('dues', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $due = Due::latest('id')->first();

        $this->assertEquals($user->id, $due->user_id);
    }
}
