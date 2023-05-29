<?php

namespace App\Http\Controllers\Api;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Http\Resources\SectionCollection;
use App\Http\Requests\SectionStoreRequest;
use App\Http\Requests\SectionUpdateRequest;

class SectionController extends Controller
{
    public function index(Request $request): SectionCollection
    {
        $this->authorize('view-any', Section::class);

        $search = $request->get('search', '');

        $sections = Section::search($search)
            ->latest()
            ->paginate();

        return new SectionCollection($sections);
    }

    public function store(SectionStoreRequest $request): SectionResource
    {
        $this->authorize('create', Section::class);

        $validated = $request->validated();

        $section = Section::create($validated);

        return new SectionResource($section);
    }

    public function show(Request $request, Section $section): SectionResource
    {
        $this->authorize('view', $section);

        return new SectionResource($section);
    }

    public function update(
        SectionUpdateRequest $request,
        Section $section
    ): SectionResource {
        $this->authorize('update', $section);

        $validated = $request->validated();

        $section->update($validated);

        return new SectionResource($section);
    }

    public function destroy(Request $request, Section $section): Response
    {
        $this->authorize('delete', $section);

        $section->delete();

        return response()->noContent();
    }
}
