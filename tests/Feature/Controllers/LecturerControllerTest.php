<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Lecturer;

use App\Models\Faculty;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LecturerControllerTest extends TestCase
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
    public function it_displays_index_view_with_lecturers(): void
    {
        $lecturers = Lecturer::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('lecturers.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.lecturers.index')
            ->assertViewHas('lecturers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_lecturer(): void
    {
        $response = $this->get(route('lecturers.create'));

        $response->assertOk()->assertViewIs('app.lecturers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_lecturer(): void
    {
        $data = Lecturer::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('lecturers.store'), $data);

        $this->assertDatabaseHas('lecturers', $data);

        $lecturer = Lecturer::latest('id')->first();

        $response->assertRedirect(route('lecturers.edit', $lecturer));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_lecturer(): void
    {
        $lecturer = Lecturer::factory()->create();

        $response = $this->get(route('lecturers.show', $lecturer));

        $response
            ->assertOk()
            ->assertViewIs('app.lecturers.show')
            ->assertViewHas('lecturer');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_lecturer(): void
    {
        $lecturer = Lecturer::factory()->create();

        $response = $this->get(route('lecturers.edit', $lecturer));

        $response
            ->assertOk()
            ->assertViewIs('app.lecturers.edit')
            ->assertViewHas('lecturer');
    }

    /**
     * @test
     */
    public function it_updates_the_lecturer(): void
    {
        $lecturer = Lecturer::factory()->create();

        $user = User::factory()->create();
        $faculty = Faculty::factory()->create();

        $data = [
            'staff_id' => $this->faker->text(255),
            'user_id' => $user->id,
            'faculty_id' => $faculty->id,
        ];

        $response = $this->put(route('lecturers.update', $lecturer), $data);

        $data['id'] = $lecturer->id;

        $this->assertDatabaseHas('lecturers', $data);

        $response->assertRedirect(route('lecturers.edit', $lecturer));
    }

    /**
     * @test
     */
    public function it_deletes_the_lecturer(): void
    {
        $lecturer = Lecturer::factory()->create();

        $response = $this->delete(route('lecturers.destroy', $lecturer));

        $response->assertRedirect(route('lecturers.index'));

        $this->assertModelMissing($lecturer);
    }
}
