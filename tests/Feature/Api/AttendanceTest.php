<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Attendance;

use App\Models\Student;
use App\Models\Classroom;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttendanceTest extends TestCase
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
    public function it_gets_attendances_list(): void
    {
        $attendances = Attendance::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.attendances.index'));

        $response->assertOk()->assertSee($attendances[0]->status);
    }

    /**
     * @test
     */
    public function it_stores_the_attendance(): void
    {
        $data = Attendance::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.attendances.store'), $data);

        $this->assertDatabaseHas('attendances', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_attendance(): void
    {
        $attendance = Attendance::factory()->create();

        $student = Student::factory()->create();
        $classroom = Classroom::factory()->create();

        $data = [
            'status' => $this->faker->word(),
            'student_id' => $student->id,
            'classroom_id' => $classroom->id,
        ];

        $response = $this->putJson(
            route('api.attendances.update', $attendance),
            $data
        );

        $data['id'] = $attendance->id;

        $this->assertDatabaseHas('attendances', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_attendance(): void
    {
        $attendance = Attendance::factory()->create();

        $response = $this->deleteJson(
            route('api.attendances.destroy', $attendance)
        );

        $this->assertModelMissing($attendance);

        $response->assertNoContent();
    }
}
