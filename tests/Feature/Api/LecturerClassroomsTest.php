<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lecturer;
use App\Models\Classroom;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LecturerClassroomsTest extends TestCase
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
    public function it_gets_lecturer_classrooms(): void
    {
        $lecturer = Lecturer::factory()->create();
        $classrooms = Classroom::factory()
            ->count(2)
            ->create([
                'lecturer_id' => $lecturer->id,
            ]);

        $response = $this->getJson(
            route('api.lecturers.classrooms.index', $lecturer)
        );

        $response->assertOk()->assertSee($classrooms[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_lecturer_classrooms(): void
    {
        $lecturer = Lecturer::factory()->create();
        $data = Classroom::factory()
            ->make([
                'lecturer_id' => $lecturer->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.lecturers.classrooms.store', $lecturer),
            $data
        );

        $this->assertDatabaseHas('classrooms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $classroom = Classroom::latest('id')->first();

        $this->assertEquals($lecturer->id, $classroom->lecturer_id);
    }
}
