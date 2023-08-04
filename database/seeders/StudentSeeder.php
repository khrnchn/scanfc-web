<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentsData = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'phone_no' => '+6011-2938136',
                'password' => Hash::make('password'),
                'faculty_id' => 1,
            ],
            [
                'name' => 'Ahmad Hisyam bin Suryanto Sugian',
                'email' => 'hisyam@student.uitm.com',
                'phone_no' => '+6012-3894567',
                'password' => Hash::make('password'),
                'faculty_id' => 1,
            ],
            [
                'name' => 'Muhammad Hazriq Akmal bin Zairol',
                'email' => 'hazriq@student.uitm.com',
                'phone_no' => '+6012-6745893',
                'password' => Hash::make('password'),
                'faculty_id' => 1,
            ],
            [
                'name' => 'Muhammad Fyruz Ismat bin Azmi',
                'email' => 'fyruz@student.uitm.com',
                'phone_no' => '+6012-5896734',
                'password' => Hash::make('password'),
                'faculty_id' => 1,
            ],
            [
                'name' => 'Harith Aizat bin Suhaili',
                'email' => 'bob@student.uitm.com',
                'phone_no' => '+6012-5839674',
                'password' => Hash::make('password'),
                'faculty_id' => 1,
            ],
            [
                'name' => 'Adam Aiman bin Zulkarnain',
                'email' => 'adam@student.uitm.com',
                'phone_no' => '+6012-7583964',
                'password' => Hash::make('password'),
                'faculty_id' => 1,
            ],
            [
                'name' => 'Muhammad Farhan Firdaus bin Hairol Zaman',
                'email' => 'farhan@student.uitm.com',
                'phone_no' => '+6012-8395674',
                'password' => Hash::make('password'),
                'faculty_id' => 1,
            ],
            [
                'name' => 'Muhammad Iqmal Hakim bin Ameruddin',
                'email' => 'iqmal@student.uitm.com',
                'phone_no' => '+6012-7458396',
                'password' => Hash::make('password'),
                'faculty_id' => 1,
            ],
            [
                'name' => 'Khad Midzan bin Kahalek',
                'email' => 'khas@student.uitm.com',
                'phone_no' => '+6012-74191283',
                'password' => Hash::make('password'),
                'faculty_id' => 1,
            ],
            [
                'name' => 'Salman bin Khairul Anuar',
                'email' => 'salman@student.uitm.com',
                'phone_no' => '+6019-7645839',
                'password' => Hash::make('password'),
                'faculty_id' => 1,
            ]
        ];

        foreach ($studentsData as $studentData) {
            $user = User::create($studentData);

            // Create the Student model for all users except 'Admin'
            if ($user->name !== 'Admin') {
                $matrixId = mt_rand(1000000000, 9999999999); // Generate random 10-digit matrix_id
                $student = Student::create([
                    'nfc_tag' => '',
                    'matrix_id' => $matrixId,
                    'user_id' => $user->id,
                    'faculty_id' => 1,
                    'is_active' => true,
                ]);

                // Assign students to sections for each subject with the enrollment date set to June 1, 2023
                $sectionIdsPerSubject = [
                    1 => [1, 2, 3],
                    2 => [4, 5, 6],
                    3 => [7, 8, 9],
                ];

                foreach ($sectionIdsPerSubject as $subjectId => $sectionIds) {
                    shuffle($sectionIds);
                    $enrollmentDate = '2023-06-01';
                    $student->sections()->attach($sectionIds[0], ['enrollment_date' => $enrollmentDate]);
                }
            }
        }
    }
}
