<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Subject;
use App\Models\Lecturer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectLecturersTest extends TestCase
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
    public function it_gets_subject_lecturers(): void
    {
        $subject = Subject::factory()->create();
        $lecturer = Lecturer::factory()->create();

        $subject->lecturers()->attach($lecturer);

        $response = $this->getJson(
            route('api.subjects.lecturers.index', $subject)
        );

        $response->assertOk()->assertSee($lecturer->staff_id);
    }

    /**
     * @test
     */
    public function it_can_attach_lecturers_to_subject(): void
    {
        $subject = Subject::factory()->create();
        $lecturer = Lecturer::factory()->create();

        $response = $this->postJson(
            route('api.subjects.lecturers.store', [$subject, $lecturer])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $subject
                ->lecturers()
                ->where('lecturers.id', $lecturer->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_lecturers_from_subject(): void
    {
        $subject = Subject::factory()->create();
        $lecturer = Lecturer::factory()->create();

        $response = $this->deleteJson(
            route('api.subjects.lecturers.store', [$subject, $lecturer])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $subject
                ->lecturers()
                ->where('lecturers.id', $lecturer->id)
                ->exists()
        );
    }
}
