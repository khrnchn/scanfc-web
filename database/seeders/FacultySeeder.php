<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            [
                'name' => 'Fakulti Sains Komputer dan Matematik',
                'code' => 'FSKM',
            ],
            [
                'name' => 'Fakulti Pengurusan dan Perniagaan',
                'code' => 'FPP',
            ],
            [
                'name' => 'Fakulti Seni Lukis dan Seni Reka',
                'code' => 'FSSR',
            ],
            [
                'name' => 'Fakulti Perakaunan',
                'code' => 'FPN',
            ],
            [
                'name' => 'Fakulti Komunikasi dan Pengajian Media',
                'code' => 'FKPM',
            ],
            [
                'name' => 'Fakulti Pengurusan Hotel dan Pelancongan',
                'code' => 'FPHP',
            ],
        ];

        foreach ($faculties as $facultyData) {
            Faculty::create($facultyData);
        }
    }
}
