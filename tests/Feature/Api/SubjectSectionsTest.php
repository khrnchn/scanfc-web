<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Subject;
use App\Models\Section;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectSectionsTest extends TestCase
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
    public function it_gets_subject_sections(): void
    {
        $subject = Subject::factory()->create();
        $sections = Section::factory()
            ->count(2)
            ->create([
                'subject_id' => $subject->id,
            ]);

        $response = $this->getJson(
            route('api.subjects.sections.index', $subject)
        );

        $response->assertOk()->assertSee($sections[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_subject_sections(): void
    {
        $subject = Subject::factory()->create();
        $data = Section::factory()
            ->make([
                'subject_id' => $subject->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.subjects.sections.store', $subject),
            $data
        );

        $this->assertDatabaseHas('sections', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $section = Section::latest('id')->first();

        $this->assertEquals($subject->id, $section->subject_id);
    }
}
