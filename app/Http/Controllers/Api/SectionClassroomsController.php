<?php

namespace App\Http\Controllers\Api;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassroomResource;
use App\Http\Resources\ClassroomCollection;

class SectionClassroomsController extends Controller
{
    public function index(
        Request $request,
        Section $section
    ): ClassroomCollection {
        $this->authorize('view', $section);

        $search = $request->get('search', '');

        $classrooms = $section
            ->classrooms()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClassroomCollection($classrooms);
    }

    public function store(Request $request, Section $section): ClassroomResource
    {
        $this->authorize('create', Classroom::class);

        $validated = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'lecturer_id' => ['required', 'exists:lecturers,id'],
            'name' => ['required', 'max:255', 'string'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date'],
        ]);

        $classroom = $section->classrooms()->create($validated);

        return new ClassroomResource($classroom);
    }
}
