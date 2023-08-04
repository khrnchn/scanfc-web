<?php

namespace App\Http\Controllers\Api;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Http\Resources\SectionCollection;

class SubjectSectionsController extends Controller
{
    public function index(Request $request, Subject $subject): SectionCollection
    {
        $this->authorize('view', $subject);

        $search = $request->get('search', '');

        $sections = $subject
            ->sections()
            ->search($search)
            ->latest()
            ->paginate();

        return new SectionCollection($sections);
    }

    public function store(Request $request, Subject $subject): SectionResource
    {
        $this->authorize('create', Section::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
        ]);

        $section = $subject->sections()->create($validated);

        return new SectionResource($section);
    }
}
