<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectionId = 1;

        $classrooms = [
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'start_at' => '2023-07-24 10:00:00',
                'end_at' => '2023-07-24 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'start_at' => '2023-07-27 14:00:00',
                'end_at' => '2023-07-27 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'start_at' => '2023-07-31 10:00:00',
                'end_at' => '2023-07-31 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'start_at' => '2023-08-03 14:00:00',
                'end_at' => '2023-08-03 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'start_at' => '2023-08-07 10:00:00',
                'end_at' => '2023-08-07 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'start_at' => '2023-08-10 14:00:00',
                'end_at' => '2023-08-10 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'start_at' => '2023-08-14 10:00:00',
                'end_at' => '2023-08-14 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'start_at' => '2023-08-17 14:00:00',
                'end_at' => '2023-08-17 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'start_at' => '2023-08-21 10:00:00',
                'end_at' => '2023-08-21 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'start_at' => '2023-08-24 14:00:00',
                'end_at' => '2023-08-24 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'start_at' => '2023-08-28 10:00:00',
                'end_at' => '2023-08-28 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'start_at' => '2023-08-31 14:00:00',
                'end_at' => '2023-08-31 16:00:00',
            ]
        ];

        foreach ($classrooms as $classroomData) {
            Classroom::create($classroomData);
        }
    }
}
