<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        // $this->call(PermissionsSeeder::class);

        $this->call(AttendanceSeeder::class);
        $this->call(ClassroomSeeder::class);
        $this->call(FacultySeeder::class);
        $this->call(LecturerSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(UserSeeder::class);
    }
}
