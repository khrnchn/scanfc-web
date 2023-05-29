<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Student;
use App\Models\Section;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentSectionsTest extends TestCase
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
    public function it_gets_student_sections(): void
    {
        $student = Student::factory()->create();
        $section = Section::factory()->create();

        $student->sections()->attach($section);

        $response = $this->getJson(
            route('api.students.sections.index', $student)
        );

        $response->assertOk()->assertSee($section->name);
    }

    /**
     * @test
     */
    public function it_can_attach_sections_to_student(): void
    {
        $student = Student::factory()->create();
        $section = Section::factory()->create();

        $response = $this->postJson(
            route('api.students.sections.store', [$student, $section])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $student
                ->sections()
                ->where('sections.id', $section->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_sections_from_student(): void
    {
        $student = Student::factory()->create();
        $section = Section::factory()->create();

        $response = $this->deleteJson(
            route('api.students.sections.store', [$student, $section])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $student
                ->sections()
                ->where('sections.id', $section->id)
                ->exists()
        );
    }
}
