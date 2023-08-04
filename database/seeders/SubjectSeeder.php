<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // name, code, faculty ID
        $subjects = [
            [
                'name' => 'E Commerce Application',
                'code' => 'ISP641',
                'faculty_id' => 1,
            ],
            [
                'name' => 'Project Development',
                'code' => 'CSP650',
                'faculty_id' => 1,
            ],
            [
                'name' => 'Artificial Intelligence',
                'code' => 'ITS662',
                'faculty_id' => 1,
            ],
            [
                'name' => 'Software Testing',
                'code' => 'ISP601',
                'faculty_id' => 1,
            ],
        ];

        $lecturerIds = [1, 2, 3]; // Replace these with the existing lecturer IDs
        $lecturerCount = count($lecturerIds);

        foreach ($subjects as $subjectData) {
            $subject = Subject::create($subjectData);

            // Create three sections (Class A, Class B, Class C) for each subject
            foreach (['A', 'B', 'C'] as $sectionName) {
                $lecturerId = $lecturerIds[0]; // Get the first lecturer ID from the array
                array_push($lecturerIds, array_shift($lecturerIds)); // Move the first lecturer ID to the end of the array

                Section::create([
                    'subject_id' => $subject->id,
                    'lecturer_id' => $lecturerId,
                    'name' => 'Class ' . $sectionName,
                ]);
            }
        }
    }
}
