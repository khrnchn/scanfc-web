<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existingRole = Role::where('name', 'filament_user')->first();

        if ($existingRole) {
            $existingRole->name = 'lecturer';
            $existingRole->save();
        } else {
            // Create the 'lecturer' role if it doesn't exist
            $lecturerRole = Role::firstOrCreate(['name' => 'lecturer']);
        }

        $users = [
            [
                'name' => 'Dr. Muhammad Rahimi bin Shahrul Nizam',
                'email' => 'rahimi@uitm.com',
                'phone_no' => '+6012-3456789',
                'password' => Hash::make('password'),
                'faculty_id' => 1,
            ],
            [
                'name' => 'Dr. Muhammad Shamim Adham bin Sofian',
                'email' => 'shamim@uitm.com',
                'phone_no' => '+6012-6789345',
                'password' => Hash::make('password'),
                'faculty_id' => 1,
            ],
            [
                'name' => 'Dr. Izzat Haiqal bin Zamani',
                'email' => 'izzat@uitm.com',
                'phone_no' => '+6012-3458967',
                'password' => Hash::make('password'),
                'faculty_id' => 1,
            ]
        ];

        foreach ($users as $index => $userData) {
            $user = User::create($userData);
            $user->assignRole($existingRole);

            $staffId = 'STAFF' . str_pad($index + 1, 3, '0', STR_PAD_LEFT); // Generate unique staff_id
            Lecturer::create([
                'staff_id' => $staffId,
                'user_id' => $user->id,
                'faculty_id' => 1,
            ]);
        }
    }
}
