<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Lecturer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FacultyLecturersTest extends TestCase
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
    public function it_gets_faculty_lecturers(): void
    {
        $faculty = Faculty::factory()->create();
        $lecturers = Lecturer::factory()
            ->count(2)
            ->create([
                'faculty_id' => $faculty->id,
            ]);

        $response = $this->getJson(
            route('api.faculties.lecturers.index', $faculty)
        );

        $response->assertOk()->assertSee($lecturers[0]->staff_id);
    }

    /**
     * @test
     */
    public function it_stores_the_faculty_lecturers(): void
    {
        $faculty = Faculty::factory()->create();
        $data = Lecturer::factory()
            ->make([
                'faculty_id' => $faculty->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.faculties.lecturers.store', $faculty),
            $data
        );

        $this->assertDatabaseHas('lecturers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $lecturer = Lecturer::latest('id')->first();

        $this->assertEquals($faculty->id, $lecturer->faculty_id);
    }
}
