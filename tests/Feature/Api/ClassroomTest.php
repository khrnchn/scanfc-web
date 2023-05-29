<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Classroom;

use App\Models\Subject;
use App\Models\Section;
use App\Models\Lecturer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassroomTest extends TestCase
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
    public function it_gets_classrooms_list(): void
    {
        $classrooms = Classroom::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.classrooms.index'));

        $response->assertOk()->assertSee($classrooms[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_classroom(): void
    {
        $data = Classroom::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.classrooms.store'), $data);

        $this->assertDatabaseHas('classrooms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_classroom(): void
    {
        $classroom = Classroom::factory()->create();

        $subject = Subject::factory()->create();
        $section = Section::factory()->create();
        $lecturer = Lecturer::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'start_at' => $this->faker->dateTime(),
            'end_at' => $this->faker->dateTime(),
            'subject_id' => $subject->id,
            'section_id' => $section->id,
            'lecturer_id' => $lecturer->id,
        ];

        $response = $this->putJson(
            route('api.classrooms.update', $classroom),
            $data
        );

        $data['id'] = $classroom->id;

        $this->assertDatabaseHas('classrooms', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_classroom(): void
    {
        $classroom = Classroom::factory()->create();

        $response = $this->deleteJson(
            route('api.classrooms.destroy', $classroom)
        );

        $this->assertModelMissing($classroom);

        $response->assertNoContent();
    }
}
