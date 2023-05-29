<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Faculty;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FacultyControllerTest extends TestCase
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
    public function it_displays_index_view_with_faculties(): void
    {
        $faculties = Faculty::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('faculties.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.faculties.index')
            ->assertViewHas('faculties');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_faculty(): void
    {
        $response = $this->get(route('faculties.create'));

        $response->assertOk()->assertViewIs('app.faculties.create');
    }

    /**
     * @test
     */
    public function it_stores_the_faculty(): void
    {
        $data = Faculty::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('faculties.store'), $data);

        $this->assertDatabaseHas('faculties', $data);

        $faculty = Faculty::latest('id')->first();

        $response->assertRedirect(route('faculties.edit', $faculty));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_faculty(): void
    {
        $faculty = Faculty::factory()->create();

        $response = $this->get(route('faculties.show', $faculty));

        $response
            ->assertOk()
            ->assertViewIs('app.faculties.show')
            ->assertViewHas('faculty');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_faculty(): void
    {
        $faculty = Faculty::factory()->create();

        $response = $this->get(route('faculties.edit', $faculty));

        $response
            ->assertOk()
            ->assertViewIs('app.faculties.edit')
            ->assertViewHas('faculty');
    }

    /**
     * @test
     */
    public function it_updates_the_faculty(): void
    {
        $faculty = Faculty::factory()->create();

        $data = [
            'name' => $this->faker->name(),
        ];

        $response = $this->put(route('faculties.update', $faculty), $data);

        $data['id'] = $faculty->id;

        $this->assertDatabaseHas('faculties', $data);

        $response->assertRedirect(route('faculties.edit', $faculty));
    }

    /**
     * @test
     */
    public function it_deletes_the_faculty(): void
    {
        $faculty = Faculty::factory()->create();

        $response = $this->delete(route('faculties.destroy', $faculty));

        $response->assertRedirect(route('faculties.index'));

        $this->assertModelMissing($faculty);
    }
}
