<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;

class UserStudentsController extends Controller
{
    public function index(Request $request, User $user): StudentCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $students = $user
            ->students()
            ->search($search)
            ->latest()
            ->paginate();

        return new StudentCollection($students);
    }

    public function store(Request $request, User $user): StudentResource
    {
        $this->authorize('create', Student::class);

        $validated = $request->validate([
            'matrix_id' => ['required', 'max:255', 'string'],
            'nfc_tag' => ['required', 'max:255', 'string'],
            'faculty_id' => ['required', 'exists:faculties,id'],
            'is_active' => ['required', 'boolean'],
        ]);

        $student = $user->students()->create($validated);

        return new StudentResource($student);
    }
}
