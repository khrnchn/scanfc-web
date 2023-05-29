<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Subject;
use App\Models\Classroom;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectClassroomsTest extends TestCase
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
    public function it_gets_subject_classrooms(): void
    {
        $subject = Subject::factory()->create();
        $classrooms = Classroom::factory()
            ->count(2)
            ->create([
                'subject_id' => $subject->id,
            ]);

        $response = $this->getJson(
            route('api.subjects.classrooms.index', $subject)
        );

        $response->assertOk()->assertSee($classrooms[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_subject_classrooms(): void
    {
        $subject = Subject::factory()->create();
        $data = Classroom::factory()
            ->make([
                'subject_id' => $subject->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.subjects.classrooms.store', $subject),
            $data
        );

        $this->assertDatabaseHas('classrooms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $classroom = Classroom::latest('id')->first();

        $this->assertEquals($subject->id, $classroom->subject_id);
    }
}
