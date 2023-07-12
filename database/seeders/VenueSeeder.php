<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // name, code, faculty ID
        $venues = [
            // dewan kuliah
            [
                'name' => 'Dewan Kuliah 1',
                'type' => '0',
                'code' => 'DK1',
                'faculty_id' => 1,
            ],
            [
                'name' => 'Dewan Kuliah 2',
                'type' => '0',
                'code' => 'DK2',
                'faculty_id' => 1,
            ],
            [
                'name' => 'Dewan Kuliah 3',
                'type' => '0',
                'code' => 'DK3',
                'faculty_id' => 1,
            ],
            
            // dewan seminar
            [
                'name' => 'Dewan Seminar 1',
                'type' => '1',
                'code' => 'DS1',
                'faculty_id' => 1,
            ],
            [
                'name' => 'Dewan Seminar 2',
                'type' => '1',
                'code' => 'DS2',
                'faculty_id' => 1,
            ],
            [
                'name' => 'Dewan Seminar 3',
                'type' => '1',
                'code' => 'DS3',
                'faculty_id' => 1,
            ],

            // bilik kuliah
            [
                'name' => 'Bilik Kuliah 1',
                'type' => '2',
                'code' => 'BK1',
                'faculty_id' => 1,
            ],
            [
                'name' => 'Bilik Kuliah 2',
                'type' => '2',
                'code' => 'BK2',
                'faculty_id' => 1,
            ],
            [
                'name' => 'Bilik Kuliah 3',
                'type' => '2',
                'code' => 'BK3',
                'faculty_id' => 1,
            ],
        ];

        foreach ($venues as $venueData) {
            $venue = Venue::create($venueData);
        }
    }
}
