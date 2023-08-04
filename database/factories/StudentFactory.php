<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matrix_id' => $this->faker->text(255),
            'nfc_tag' => $this->faker->text(255),
            'is_active' => $this->faker->boolean(),
            'user_id' => \App\Models\User::factory(),
            'faculty_id' => \App\Models\Faculty::factory(),
        ];
    }
}
