<?php

namespace App\Http\Controllers\Api;

use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\LecturerResource;
use App\Http\Resources\LecturerCollection;
use App\Http\Requests\LecturerStoreRequest;
use App\Http\Requests\LecturerUpdateRequest;

class LecturerController extends Controller
{
    public function index(Request $request): LecturerCollection
    {
        $this->authorize('view-any', Lecturer::class);

        $search = $request->get('search', '');

        $lecturers = Lecturer::search($search)
            ->latest()
            ->paginate();

        return new LecturerCollection($lecturers);
    }

    public function store(LecturerStoreRequest $request): LecturerResource
    {
        $this->authorize('create', Lecturer::class);

        $validated = $request->validated();

        $lecturer = Lecturer::create($validated);

        return new LecturerResource($lecturer);
    }

    public function show(Request $request, Lecturer $lecturer): LecturerResource
    {
        $this->authorize('view', $lecturer);

        return new LecturerResource($lecturer);
    }

    public function update(
        LecturerUpdateRequest $request,
        Lecturer $lecturer
    ): LecturerResource {
        $this->authorize('update', $lecturer);

        $validated = $request->validated();

        $lecturer->update($validated);

        return new LecturerResource($lecturer);
    }

    public function destroy(Request $request, Lecturer $lecturer): Response
    {
        $this->authorize('delete', $lecturer);

        $lecturer->delete();

        return response()->noContent();
    }
}
