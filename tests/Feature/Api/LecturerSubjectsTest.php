<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Subject;
use App\Models\Lecturer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LecturerSubjectsTest extends TestCase
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
    public function it_gets_lecturer_subjects(): void
    {
        $lecturer = Lecturer::factory()->create();
        $subject = Subject::factory()->create();

        $lecturer->subjects()->attach($subject);

        $response = $this->getJson(
            route('api.lecturers.subjects.index', $lecturer)
        );

        $response->assertOk()->assertSee($subject->name);
    }

    /**
     * @test
     */
    public function it_can_attach_subjects_to_lecturer(): void
    {
        $lecturer = Lecturer::factory()->create();
        $subject = Subject::factory()->create();

        $response = $this->postJson(
            route('api.lecturers.subjects.store', [$lecturer, $subject])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $lecturer
                ->subjects()
                ->where('subjects.id', $subject->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_subjects_from_lecturer(): void
    {
        $lecturer = Lecturer::factory()->create();
        $subject = Subject::factory()->create();

        $response = $this->deleteJson(
            route('api.lecturers.subjects.store', [$lecturer, $subject])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $lecturer
                ->subjects()
                ->where('subjects.id', $subject->id)
                ->exists()
        );
    }
}
