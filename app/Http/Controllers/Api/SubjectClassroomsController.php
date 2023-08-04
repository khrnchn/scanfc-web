<?php

namespace App\Http\Controllers\Api;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassroomResource;
use App\Http\Resources\ClassroomCollection;

class SubjectClassroomsController extends Controller
{
    public function index(
        Request $request,
        Subject $subject
    ): ClassroomCollection {
        $this->authorize('view', $subject);

        $search = $request->get('search', '');

        $classrooms = $subject
            ->classrooms()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClassroomCollection($classrooms);
    }

    public function store(Request $request, Subject $subject): ClassroomResource
    {
        $this->authorize('create', Classroom::class);

        $validated = $request->validate([
            'section_id' => ['required', 'exists:sections,id'],
            'lecturer_id' => ['required', 'exists:lecturers,id'],
            'name' => ['required', 'max:255', 'string'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date'],
        ]);

        $classroom = $subject->classrooms()->create($validated);

        return new ClassroomResource($classroom);
    }
}
