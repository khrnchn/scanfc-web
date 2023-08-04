<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Section;
use App\Models\Student;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectionStudentsTest extends TestCase
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
    public function it_gets_section_students(): void
    {
        $section = Section::factory()->create();
        $student = Student::factory()->create();

        $section->students()->attach($student);

        $response = $this->getJson(
            route('api.sections.students.index', $section)
        );

        $response->assertOk()->assertSee($student->matrix_id);
    }

    /**
     * @test
     */
    public function it_can_attach_students_to_section(): void
    {
        $section = Section::factory()->create();
        $student = Student::factory()->create();

        $response = $this->postJson(
            route('api.sections.students.store', [$section, $student])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $section
                ->students()
                ->where('students.id', $student->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_students_from_section(): void
    {
        $section = Section::factory()->create();
        $student = Student::factory()->create();

        $response = $this->deleteJson(
            route('api.sections.students.store', [$section, $student])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $section
                ->students()
                ->where('students.id', $student->id)
                ->exists()
        );
    }
}
