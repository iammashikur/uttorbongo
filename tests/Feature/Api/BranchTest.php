<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchTest extends TestCase
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
    public function it_gets_branches_list(): void
    {
        $branches = Branch::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.branches.index'));

        $response->assertOk()->assertSee($branches[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_branch(): void
    {
        $data = Branch::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.branches.store'), $data);

        $this->assertDatabaseHas('branches', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_branch(): void
    {
        $branch = Branch::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'address' => $this->faker->address,
        ];

        $response = $this->putJson(
            route('api.branches.update', $branch),
            $data
        );

        $data['id'] = $branch->id;

        $this->assertDatabaseHas('branches', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_branch(): void
    {
        $branch = Branch::factory()->create();

        $response = $this->deleteJson(route('api.branches.destroy', $branch));

        $this->assertModelMissing($branch);

        $response->assertNoContent();
    }
}
