<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Student;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FacultyStudentsTest extends TestCase
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
    public function it_gets_faculty_students(): void
    {
        $faculty = Faculty::factory()->create();
        $students = Student::factory()
            ->count(2)
            ->create([
                'faculty_id' => $faculty->id,
            ]);

        $response = $this->getJson(
            route('api.faculties.students.index', $faculty)
        );

        $response->assertOk()->assertSee($students[0]->matrix_id);
    }

    /**
     * @test
     */
    public function it_stores_the_faculty_students(): void
    {
        $faculty = Faculty::factory()->create();
        $data = Student::factory()
            ->make([
                'faculty_id' => $faculty->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.faculties.students.store', $faculty),
            $data
        );

        $this->assertDatabaseHas('students', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $student = Student::latest('id')->first();

        $this->assertEquals($faculty->id, $student->faculty_id);
    }
}
