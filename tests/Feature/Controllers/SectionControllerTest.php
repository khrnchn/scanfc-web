<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Section;

use App\Models\Subject;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectionControllerTest extends TestCase
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
    public function it_displays_index_view_with_sections(): void
    {
        $sections = Section::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('sections.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.sections.index')
            ->assertViewHas('sections');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_section(): void
    {
        $response = $this->get(route('sections.create'));

        $response->assertOk()->assertViewIs('app.sections.create');
    }

    /**
     * @test
     */
    public function it_stores_the_section(): void
    {
        $data = Section::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('sections.store'), $data);

        $this->assertDatabaseHas('sections', $data);

        $section = Section::latest('id')->first();

        $response->assertRedirect(route('sections.edit', $section));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_section(): void
    {
        $section = Section::factory()->create();

        $response = $this->get(route('sections.show', $section));

        $response
            ->assertOk()
            ->assertViewIs('app.sections.show')
            ->assertViewHas('section');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_section(): void
    {
        $section = Section::factory()->create();

        $response = $this->get(route('sections.edit', $section));

        $response
            ->assertOk()
            ->assertViewIs('app.sections.edit')
            ->assertViewHas('section');
    }

    /**
     * @test
     */
    public function it_updates_the_section(): void
    {
        $section = Section::factory()->create();

        $subject = Subject::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'subject_id' => $subject->id,
        ];

        $response = $this->put(route('sections.update', $section), $data);

        $data['id'] = $section->id;

        $this->assertDatabaseHas('sections', $data);

        $response->assertRedirect(route('sections.edit', $section));
    }

    /**
     * @test
     */
    public function it_deletes_the_section(): void
    {
        $section = Section::factory()->create();

        $response = $this->delete(route('sections.destroy', $section));

        $response->assertRedirect(route('sections.index'));

        $this->assertModelMissing($section);
    }
}
