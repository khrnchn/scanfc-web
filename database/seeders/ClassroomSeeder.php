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
                'start_at' => '2023-07-26 14:00:00',
                'end_at' => '2023-07-26 16:00:00',
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
                'start_at' => '2023-08-02 14:00:00',
                'end_at' => '2023-08-02 16:00:00',
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
                'start_at' => '2023-08-09 14:00:00',
                'end_at' => '2023-08-09 16:00:00',
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
                'start_at' => '2023-08-16 14:00:00',
                'end_at' => '2023-08-16 16:00:00',
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
                'start_at' => '2023-08-23 14:00:00',
                'end_at' => '2023-08-23 16:00:00',
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
                'start_at' => '2023-08-30 14:00:00',
                'end_at' => '2023-08-30 16:00:00',
            ]
        ];

        foreach ($classrooms as $classroomData) {
            Classroom::create($classroomData);
        }
    }
}
