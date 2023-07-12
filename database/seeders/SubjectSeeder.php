<?php

namespace Database\Seeders;

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

        foreach ($subjects as $subjectData) {
            $subject = Subject::create($subjectData);
        }
    }
}
