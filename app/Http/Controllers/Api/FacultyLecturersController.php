<?php

namespace App\Http\Controllers\Api;

use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LecturerResource;
use App\Http\Resources\LecturerCollection;

class FacultyLecturersController extends Controller
{
    public function index(
        Request $request,
        Faculty $faculty
    ): LecturerCollection {
        $this->authorize('view', $faculty);

        $search = $request->get('search', '');

        $lecturers = $faculty
            ->lecturers()
            ->search($search)
            ->latest()
            ->paginate();

        return new LecturerCollection($lecturers);
    }

    public function store(Request $request, Faculty $faculty): LecturerResource
    {
        $this->authorize('create', Lecturer::class);

        $validated = $request->validate([
            'staff_id' => ['required', 'max:255', 'string'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $lecturer = $faculty->lecturers()->create($validated);

        return new LecturerResource($lecturer);
    }
}
