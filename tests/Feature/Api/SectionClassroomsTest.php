<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Section;
use App\Models\Classroom;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectionClassroomsTest extends TestCase
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
    public function it_gets_section_classrooms(): void
    {
        $section = Section::factory()->create();
        $classrooms = Classroom::factory()
            ->count(2)
            ->create([
                'section_id' => $section->id,
            ]);

        $response = $this->getJson(
            route('api.sections.classrooms.index', $section)
        );

        $response->assertOk()->assertSee($classrooms[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_section_classrooms(): void
    {
        $section = Section::factory()->create();
        $data = Classroom::factory()
            ->make([
                'section_id' => $section->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.sections.classrooms.store', $section),
            $data
        );

        $this->assertDatabaseHas('classrooms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $classroom = Classroom::latest('id')->first();

        $this->assertEquals($section->id, $classroom->section_id);
    }
}
