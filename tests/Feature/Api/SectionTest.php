<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Section;

use App\Models\Subject;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectionTest extends TestCase
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
    public function it_gets_sections_list(): void
    {
        $sections = Section::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.sections.index'));

        $response->assertOk()->assertSee($sections[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_section(): void
    {
        $data = Section::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.sections.store'), $data);

        $this->assertDatabaseHas('sections', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.sections.update', $section),
            $data
        );

        $data['id'] = $section->id;

        $this->assertDatabaseHas('sections', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_section(): void
    {
        $section = Section::factory()->create();

        $response = $this->deleteJson(route('api.sections.destroy', $section));

        $this->assertModelMissing($section);

        $response->assertNoContent();
    }
}
