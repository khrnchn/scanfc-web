<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Faculty;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FacultyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_faculties_list(): void
    {
        $faculties = Faculty::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.faculties.index'));

        $response->assertOk()->assertSee($faculties[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_faculty(): void
    {
        $data = Faculty::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.faculties.store'), $data);

        $this->assertDatabaseHas('faculties', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_faculty(): void
    {
        $faculty = Faculty::factory()->create();

        $data = [
            'name' => $this->faker->name(),
        ];

        $response = $this->putJson(
            route('api.faculties.update', $faculty),
            $data
        );

        $data['id'] = $faculty->id;

        $this->assertDatabaseHas('faculties', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_faculty(): void
    {
        $faculty = Faculty::factory()->create();

        $response = $this->deleteJson(route('api.faculties.destroy', $faculty));

        $this->assertModelMissing($faculty);

        $response->assertNoContent();
    }
}
