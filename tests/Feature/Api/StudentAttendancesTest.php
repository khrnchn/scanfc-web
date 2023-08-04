<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Student;
use App\Models\Attendance;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentAttendancesTest extends TestCase
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
    public function it_gets_student_attendances(): void
    {
        $student = Student::factory()->create();
        $attendances = Attendance::factory()
            ->count(2)
            ->create([
                'student_id' => $student->id,
            ]);

        $response = $this->getJson(
            route('api.students.attendances.index', $student)
        );

        $response->assertOk()->assertSee($attendances[0]->status);
    }

    /**
     * @test
     */
    public function it_stores_the_student_attendances(): void
    {
        $student = Student::factory()->create();
        $data = Attendance::factory()
            ->make([
                'student_id' => $student->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.students.attendances.store', $student),
            $data
        );

        $this->assertDatabaseHas('attendances', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $attendance = Attendance::latest('id')->first();

        $this->assertEquals($student->id, $attendance->student_id);
    }
}
