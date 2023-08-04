<?php

namespace Database\Factories;

use App\Models\Lecturer;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class LecturerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lecturer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'staff_id' => $this->faker->text(255),
            'user_id' => \App\Models\User::factory(),
            'faculty_id' => \App\Models\Faculty::factory(),
        ];
    }
}
