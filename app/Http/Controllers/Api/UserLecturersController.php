<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LecturerResource;
use App\Http\Resources\LecturerCollection;

class UserLecturersController extends Controller
{
    public function index(Request $request, User $user): LecturerCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $lecturers = $user
            ->lecturers()
            ->search($search)
            ->latest()
            ->paginate();

        return new LecturerCollection($lecturers);
    }

    public function store(Request $request, User $user): LecturerResource
    {
        $this->authorize('create', Lecturer::class);

        $validated = $request->validate([
            'staff_id' => ['required', 'max:255', 'string'],
            'faculty_id' => ['required', 'exists:faculties,id'],
        ]);

        $lecturer = $user->lecturers()->create($validated);

        return new LecturerResource($lecturer);
    }
}
