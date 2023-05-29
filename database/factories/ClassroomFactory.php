<?php

namespace Database\Factories;

use App\Models\Classroom;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassroomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Classroom::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'start_at' => $this->faker->dateTime(),
            'end_at' => $this->faker->dateTime(),
            'subject_id' => \App\Models\Subject::factory(),
            'section_id' => \App\Models\Section::factory(),
            'lecturer_id' => \App\Models\Lecturer::factory(),
        ];
    }
}
