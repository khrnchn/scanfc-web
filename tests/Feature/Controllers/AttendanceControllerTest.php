<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Attendance;

use App\Models\Student;
use App\Models\Classroom;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttendanceControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_attendances(): void
    {
        $attendances = Attendance::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('attendances.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.attendances.index')
            ->assertViewHas('attendances');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_attendance(): void
    {
        $response = $this->get(route('attendances.create'));

        $response->assertOk()->assertViewIs('app.attendances.create');
    }

    /**
     * @test
     */
    public function it_stores_the_attendance(): void
    {
        $data = Attendance::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('attendances.store'), $data);

        $this->assertDatabaseHas('attendances', $data);

        $attendance = Attendance::latest('id')->first();

        $response->assertRedirect(route('attendances.edit', $attendance));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_attendance(): void
    {
        $attendance = Attendance::factory()->create();

        $response = $this->get(route('attendances.show', $attendance));

        $response
            ->assertOk()
            ->assertViewIs('app.attendances.show')
            ->assertViewHas('attendance');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_attendance(): void
    {
        $attendance = Attendance::factory()->create();

        $response = $this->get(route('attendances.edit', $attendance));

        $response
            ->assertOk()
            ->assertViewIs('app.attendances.edit')
            ->assertViewHas('attendance');
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

        $response = $this->put(route('attendances.update', $attendance), $data);

        $data['id'] = $attendance->id;

        $this->assertDatabaseHas('attendances', $data);

        $response->assertRedirect(route('attendances.edit', $attendance));
    }

    /**
     * @test
     */
    public function it_deletes_the_attendance(): void
    {
        $attendance = Attendance::factory()->create();

        $response = $this->delete(route('attendances.destroy', $attendance));

        $response->assertRedirect(route('attendances.index'));

        $this->assertModelMissing($attendance);
    }
}
