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
            ]
        ];

        foreach ($studentsData as $studentData) {
            $user = User::create($studentData);

            // Create the Student model for all users except 'Admin'
            if ($user->name !== 'Admin') {
                $matrixId = mt_rand(1000000000, 9999999999); // Generate random 10-digit matrix_id
                Student::create([
                    'matrix_id' => $matrixId,
                    'user_id' => $user->id,
                    'faculty_id' => 1,
                    'is_active' => true,
                ]);
            }
        }
    }
}
