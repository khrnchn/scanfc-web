<?php

namespace App\Http\Controllers\Api;

use App\Models\Lecturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassroomResource;
use App\Http\Resources\ClassroomCollection;

class LecturerClassroomsController extends Controller
{
    public function index(
        Request $request,
        Lecturer $lecturer
    ): ClassroomCollection {
        $this->authorize('view', $lecturer);

        $search = $request->get('search', '');

        $classrooms = $lecturer
            ->classrooms()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClassroomCollection($classrooms);
    }

    public function store(
        Request $request,
        Lecturer $lecturer
    ): ClassroomResource {
        $this->authorize('create', Classroom::class);

        $validated = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'name' => ['required', 'max:255', 'string'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date'],
        ]);

        $classroom = $lecturer->classrooms()->create($validated);

        return new ClassroomResource($classroom);
    }
}
