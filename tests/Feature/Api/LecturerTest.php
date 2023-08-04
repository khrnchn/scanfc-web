<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lecturer;

use App\Models\Faculty;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LecturerTest extends TestCase
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
    public function it_gets_lecturers_list(): void
    {
        $lecturers = Lecturer::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.lecturers.index'));

        $response->assertOk()->assertSee($lecturers[0]->staff_id);
    }

    /**
     * @test
     */
    public function it_stores_the_lecturer(): void
    {
        $data = Lecturer::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.lecturers.store'), $data);

        $this->assertDatabaseHas('lecturers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_lecturer(): void
    {
        $lecturer = Lecturer::factory()->create();

        $user = User::factory()->create();
        $faculty = Faculty::factory()->create();

        $data = [
            'staff_id' => $this->faker->text(255),
            'user_id' => $user->id,
            'faculty_id' => $faculty->id,
        ];

        $response = $this->putJson(
            route('api.lecturers.update', $lecturer),
            $data
        );

        $data['id'] = $lecturer->id;

        $this->assertDatabaseHas('lecturers', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_lecturer(): void
    {
        $lecturer = Lecturer::factory()->create();

        $response = $this->deleteJson(
            route('api.lecturers.destroy', $lecturer)
        );

        $this->assertModelMissing($lecturer);

        $response->assertNoContent();
    }
}
