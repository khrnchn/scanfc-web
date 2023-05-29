<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Subject;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FacultySubjectsTest extends TestCase
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
    public function it_gets_faculty_subjects(): void
    {
        $faculty = Faculty::factory()->create();
        $subjects = Subject::factory()
            ->count(2)
            ->create([
                'faculty_id' => $faculty->id,
            ]);

        $response = $this->getJson(
            route('api.faculties.subjects.index', $faculty)
        );

        $response->assertOk()->assertSee($subjects[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_faculty_subjects(): void
    {
        $faculty = Faculty::factory()->create();
        $data = Subject::factory()
            ->make([
                'faculty_id' => $faculty->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.faculties.subjects.store', $faculty),
            $data
        );

        $this->assertDatabaseHas('subjects', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $subject = Subject::latest('id')->first();

        $this->assertEquals($faculty->id, $subject->faculty_id);
    }
}
