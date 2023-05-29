<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Classroom;

use App\Models\Subject;
use App\Models\Section;
use App\Models\Lecturer;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassroomControllerTest extends TestCase
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
    public function it_displays_index_view_with_classrooms(): void
    {
        $classrooms = Classroom::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('classrooms.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.classrooms.index')
            ->assertViewHas('classrooms');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_classroom(): void
    {
        $response = $this->get(route('classrooms.create'));

        $response->assertOk()->assertViewIs('app.classrooms.create');
    }

    /**
     * @test
     */
    public function it_stores_the_classroom(): void
    {
        $data = Classroom::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('classrooms.store'), $data);

        $this->assertDatabaseHas('classrooms', $data);

        $classroom = Classroom::latest('id')->first();

        $response->assertRedirect(route('classrooms.edit', $classroom));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_classroom(): void
    {
        $classroom = Classroom::factory()->create();

        $response = $this->get(route('classrooms.show', $classroom));

        $response
            ->assertOk()
            ->assertViewIs('app.classrooms.show')
            ->assertViewHas('classroom');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_classroom(): void
    {
        $classroom = Classroom::factory()->create();

        $response = $this->get(route('classrooms.edit', $classroom));

        $response
            ->assertOk()
            ->assertViewIs('app.classrooms.edit')
            ->assertViewHas('classroom');
    }

    /**
     * @test
     */
    public function it_updates_the_classroom(): void
    {
        $classroom = Classroom::factory()->create();

        $subject = Subject::factory()->create();
        $section = Section::factory()->create();
        $lecturer = Lecturer::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'start_at' => $this->faker->dateTime(),
            'end_at' => $this->faker->dateTime(),
            'subject_id' => $subject->id,
            'section_id' => $section->id,
            'lecturer_id' => $lecturer->id,
        ];

        $response = $this->put(route('classrooms.update', $classroom), $data);

        $data['id'] = $classroom->id;

        $this->assertDatabaseHas('classrooms', $data);

        $response->assertRedirect(route('classrooms.edit', $classroom));
    }

    /**
     * @test
     */
    public function it_deletes_the_classroom(): void
    {
        $classroom = Classroom::factory()->create();

        $response = $this->delete(route('classrooms.destroy', $classroom));

        $response->assertRedirect(route('classrooms.index'));

        $this->assertModelMissing($classroom);
    }
}
