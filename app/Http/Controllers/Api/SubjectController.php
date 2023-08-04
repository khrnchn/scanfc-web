<?php

namespace App\Http\Controllers\Api;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\SubjectCollection;
use App\Http\Requests\SubjectStoreRequest;
use App\Http\Requests\SubjectUpdateRequest;

class SubjectController extends Controller
{
    public function index(Request $request): SubjectCollection
    {
        $this->authorize('view-any', Subject::class);

        $search = $request->get('search', '');

        $subjects = Subject::search($search)
            ->latest()
            ->paginate();

        return new SubjectCollection($subjects);
    }

    public function store(SubjectStoreRequest $request): SubjectResource
    {
        $this->authorize('create', Subject::class);

        $validated = $request->validated();

        $subject = Subject::create($validated);

        return new SubjectResource($subject);
    }

    public function show(Request $request, Subject $subject): SubjectResource
    {
        $this->authorize('view', $subject);

        return new SubjectResource($subject);
    }

    public function update(
        SubjectUpdateRequest $request,
        Subject $subject
    ): SubjectResource {
        $this->authorize('update', $subject);

        $validated = $request->validated();

        $subject->update($validated);

        return new SubjectResource($subject);
    }

    public function destroy(Request $request, Subject $subject): Response
    {
        $this->authorize('delete', $subject);

        $subject->delete();

        return response()->noContent();
    }
}
