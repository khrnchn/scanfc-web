<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attendance::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->word(),
            'student_id' => \App\Models\Student::factory(),
            'classroom_id' => \App\Models\Classroom::factory(),
        ];
    }
}
