<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lecturer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLecturersTest extends TestCase
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
    public function it_gets_user_lecturers(): void
    {
        $user = User::factory()->create();
        $lecturers = Lecturer::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.lecturers.index', $user));

        $response->assertOk()->assertSee($lecturers[0]->staff_id);
    }

    /**
     * @test
     */
    public function it_stores_the_user_lecturers(): void
    {
        $user = User::factory()->create();
        $data = Lecturer::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.lecturers.store', $user),
            $data
        );

        $this->assertDatabaseHas('lecturers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $lecturer = Lecturer::latest('id')->first();

        $this->assertEquals($user->id, $lecturer->user_id);
    }
}
