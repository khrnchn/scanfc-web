<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Attendance;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassroomAttendancesTest extends TestCase
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
    public function it_gets_classroom_attendances(): void
    {
        $classroom = Classroom::factory()->create();
        $attendances = Attendance::factory()
            ->count(2)
            ->create([
                'classroom_id' => $classroom->id,
            ]);

        $response = $this->getJson(
            route('api.classrooms.attendances.index', $classroom)
        );

        $response->assertOk()->assertSee($attendances[0]->status);
    }

    /**
     * @test
     */
    public function it_stores_the_classroom_attendances(): void
    {
        $classroom = Classroom::factory()->create();
        $data = Attendance::factory()
            ->make([
                'classroom_id' => $classroom->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.classrooms.attendances.store', $classroom),
            $data
        );

        $this->assertDatabaseHas('attendances', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $attendance = Attendance::latest('id')->first();

        $this->assertEquals($classroom->id, $attendance->classroom_id);
    }
}
