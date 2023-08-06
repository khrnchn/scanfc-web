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

        Classroom::where('section_id', 2)->delete();

        $classrooms = [
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-07-23 10:00:00',
                'end_at' => '2023-07-23 12:00:00',
                'hasRecordedAttendance' => true,
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-07-23 14:00:00',
                'end_at' => '2023-07-23 16:00:00',
                'hasRecordedAttendance' => true,
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-07-30 10:00:00',
                'end_at' => '2023-07-30 12:00:00',
                'hasRecordedAttendance' => true,
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-07-30 14:00:00',
                'end_at' => '2023-07-30 16:00:00',
                'hasRecordedAttendance' => true,
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-08-06 10:00:00',
                'end_at' => '2023-08-06 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Online(),
                'start_at' => '2023-08-06 14:00:00',
                'end_at' => '2023-08-06 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-08-13 10:00:00',
                'end_at' => '2023-08-13 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-08-13 14:00:00',
                'end_at' => '2023-08-13 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-08-20 10:00:00',
                'end_at' => '2023-08-20 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-08-20 14:00:00',
                'end_at' => '2023-08-20 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-08-27 10:00:00',
                'end_at' => '2023-08-27 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-09-27 14:00:00',
                'end_at' => '2023-09-27 16:00:00',
            ]
        ];

        foreach ($classrooms as $classroomData) {
            Classroom::create($classroomData);
        }
    }
}
