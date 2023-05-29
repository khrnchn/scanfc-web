<?php

namespace App\Http\Controllers\Api;

use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\SubjectCollection;

class FacultySubjectsController extends Controller
{
    public function index(Request $request, Faculty $faculty): SubjectCollection
    {
        $this->authorize('view', $faculty);

        $search = $request->get('search', '');

        $subjects = $faculty
            ->subjects()
            ->search($search)
            ->latest()
            ->paginate();

        return new SubjectCollection($subjects);
    }

    public function store(Request $request, Faculty $faculty): SubjectResource
    {
        $this->authorize('create', Subject::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
        ]);

        $subject = $faculty->subjects()->create($validated);

        return new SubjectResource($subject);
    }
}
