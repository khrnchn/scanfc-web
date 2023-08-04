<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Subject;

use App\Models\Faculty;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectTest extends TestCase
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
    public function it_gets_subjects_list(): void
    {
        $subjects = Subject::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.subjects.index'));

        $response->assertOk()->assertSee($subjects[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_subject(): void
    {
        $data = Subject::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.subjects.store'), $data);

        $this->assertDatabaseHas('subjects', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.subjects.update', $subject),
            $data
        );

        $data['id'] = $subject->id;

        $this->assertDatabaseHas('subjects', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_subject(): void
    {
        $subject = Subject::factory()->create();

        $response = $this->deleteJson(route('api.subjects.destroy', $subject));

        $this->assertModelMissing($subject);

        $response->assertNoContent();
    }
}
