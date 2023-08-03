<?php

namespace Database\Seeders;

use App\Enums\ClassTypeEnum;
use App\Models\Classroom;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectionId = 2;

        $classrooms = [
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(), 
                'start_at' => '2023-07-24 10:00:00',
                'end_at' => '2023-07-24 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(), // physical
                'start_at' => '2023-07-28 14:00:00',
                'end_at' => '2023-07-28 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(), // physical
                'start_at' => '2023-07-31 10:00:00',
                'end_at' => '2023-07-31 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(), // physical
                'start_at' => '2023-08-04 14:00:00',
                'end_at' => '2023-08-04 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(), // physical
                'start_at' => '2023-08-07 10:00:00',
                'end_at' => '2023-08-07 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(), // physical
                'start_at' => '2023-08-11 14:00:00',
                'end_at' => '2023-08-11 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(), // physical
                'start_at' => '2023-08-14 10:00:00',
                'end_at' => '2023-08-14 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(), // physical
                'start_at' => '2023-08-18 14:00:00',
                'end_at' => '2023-08-18 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(), // physical
                'start_at' => '2023-08-21 10:00:00',
                'end_at' => '2023-08-21 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(), // physical
                'start_at' => '2023-08-25 14:00:00',
                'end_at' => '2023-08-25 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(), // physical
                'start_at' => '2023-08-28 10:00:00',
                'end_at' => '2023-08-28 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(), // physical
                'start_at' => '2023-09-01 14:00:00',
                'end_at' => '2023-09-01 16:00:00',
            ]
        ];

        foreach ($classrooms as $classroomData) {
            Classroom::create($classroomData);
        }
    }
}
