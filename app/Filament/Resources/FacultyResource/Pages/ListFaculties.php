<?php

namespace App\Filament\Resources\FacultyResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\FacultyResource;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\Builder;

class ListFaculties extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = FacultyResource::class;

    protected function getTableQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole('lecturer')) {
            // Assuming you have a 'lecturer' relationship defined in the User model
            $lecturer = $user->lecturer;

            if ($lecturer) {
                // Assuming you have a 'faculty' relationship defined in the Lecturer model
                $faculty = $lecturer->faculty;

                if ($faculty) {
                    // Only return the faculty that belongs to the lecturer
                    return Faculty::where('id', $faculty->id);
                }
            }
        }

        // For other roles, return all faculties
        return Faculty::query();
    }
}
