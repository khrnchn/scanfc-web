<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(FacultySeeder::class);
        $this->call(VenueSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(StudentSeeder::class);
    }
}
