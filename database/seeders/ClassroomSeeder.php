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
        $sectionId = 3;

        Classroom::where('section_id', 3)->delete();

        $classrooms = [
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-07-24 10:00:00',
                'end_at' => '2023-07-24 12:00:00',
                'hasRecordedAttendance' => true,
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-07-24 14:00:00',
                'end_at' => '2023-07-24 16:00:00',
                'hasRecordedAttendance' => true,
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-07-31 10:00:00',
                'end_at' => '2023-07-31 12:00:00',
                'hasRecordedAttendance' => true,
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-07-31 14:00:00',
                'end_at' => '2023-07-31 16:00:00',
                'hasRecordedAttendance' => true,
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-08-07 10:00:00',
                'end_at' => '2023-08-07 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Online(),
                'start_at' => '2023-08-07 14:00:00',
                'end_at' => '2023-08-07 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-08-14 10:00:00',
                'end_at' => '2023-08-14 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-08-14 14:00:00',
                'end_at' => '2023-08-14 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-08-21 10:00:00',
                'end_at' => '2023-08-21 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-08-21 14:00:00',
                'end_at' => '2023-08-21 16:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 2,
                'name' => 'Lecture',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-08-28 10:00:00',
                'end_at' => '2023-08-28 12:00:00',
            ],
            [
                'section_id' => $sectionId,
                'venue_id' => 8,
                'name' => 'Lab',
                'type' => ClassTypeEnum::Physical(),
                'start_at' => '2023-08-28 14:00:00',
                'end_at' => '2023-08-28 16:00:00',
            ]
        ];

        foreach ($classrooms as $classroomData) {
            Classroom::create($classroomData);
        }
    }
}
