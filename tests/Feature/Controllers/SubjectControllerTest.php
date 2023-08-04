<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Subject;

use App\Models\Faculty;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectControllerTest extends TestCase
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
    public function it_displays_index_view_with_subjects(): void
    {
        $subjects = Subject::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('subjects.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.subjects.index')
            ->assertViewHas('subjects');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_subject(): void
    {
        $response = $this->get(route('subjects.create'));

        $response->assertOk()->assertViewIs('app.subjects.create');
    }

    /**
     * @test
     */
    public function it_stores_the_subject(): void
    {
        $data = Subject::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('subjects.store'), $data);

        $this->assertDatabaseHas('subjects', $data);

        $subject = Subject::latest('id')->first();

        $response->assertRedirect(route('subjects.edit', $subject));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_subject(): void
    {
        $subject = Subject::factory()->create();

        $response = $this->get(route('subjects.show', $subject));

        $response
            ->assertOk()
            ->assertViewIs('app.subjects.show')
            ->assertViewHas('subject');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_subject(): void
    {
        $subject = Subject::factory()->create();

        $response = $this->get(route('subjects.edit', $subject));

        $response
            ->assertOk()
            ->assertViewIs('app.subjects.edit')
            ->assertViewHas('subject');
    }

    /**
     * @test
     */
    public function it_updates_the_subject(): void
    {
        $subject = Subject::factory()->create();

        $faculty = Faculty::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'faculty_id' => $faculty->id,
        ];

        $response = $this->put(route('subjects.update', $subject), $data);

        $data['id'] = $subject->id;

        $this->assertDatabaseHas('subjects', $data);

        $response->assertRedirect(route('subjects.edit', $subject));
    }

    /**
     * @test
     */
    public function it_deletes_the_subject(): void
    {
        $subject = Subject::factory()->create();

        $response = $this->delete(route('subjects.destroy', $subject));

        $response->assertRedirect(route('subjects.index'));

        $this->assertModelMissing($subject);
    }
}
