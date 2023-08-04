<?php

namespace App\Http\Controllers\Api;

use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;

class FacultyStudentsController extends Controller
{
    public function index(Request $request, Faculty $faculty): StudentCollection
    {
        $this->authorize('view', $faculty);

        $search = $request->get('search', '');

        $students = $faculty
            ->students()
            ->search($search)
            ->latest()
            ->paginate();

        return new StudentCollection($students);
    }

    public function store(Request $request, Faculty $faculty): StudentResource
    {
        $this->authorize('create', Student::class);

        $validated = $request->validate([
            'matrix_id' => ['required', 'max:255', 'string'],
            'nfc_tag' => ['required', 'max:255', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'is_active' => ['required', 'boolean'],
        ]);

        $student = $faculty->students()->create($validated);

        return new StudentResource($student);
    }
}
