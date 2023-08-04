<?php

namespace App\Http\Controllers\Api;

use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\FacultyResource;
use App\Http\Resources\FacultyCollection;
use App\Http\Requests\FacultyStoreRequest;
use App\Http\Requests\FacultyUpdateRequest;

class FacultyController extends Controller
{
    public function index(Request $request): FacultyCollection
    {
        $this->authorize('view-any', Faculty::class);

        $search = $request->get('search', '');

        $faculties = Faculty::search($search)
            ->latest()
            ->paginate();

        return new FacultyCollection($faculties);
    }

    public function store(FacultyStoreRequest $request): FacultyResource
    {
        $this->authorize('create', Faculty::class);

        $validated = $request->validated();

        $faculty = Faculty::create($validated);

        return new FacultyResource($faculty);
    }

    public function show(Request $request, Faculty $faculty): FacultyResource
    {
        $this->authorize('view', $faculty);

        return new FacultyResource($faculty);
    }

    public function update(
        FacultyUpdateRequest $request,
        Faculty $faculty
    ): FacultyResource {
        $this->authorize('update', $faculty);

        $validated = $request->validated();

        $faculty->update($validated);

        return new FacultyResource($faculty);
    }

    public function destroy(Request $request, Faculty $faculty): Response
    {
        $this->authorize('delete', $faculty);

        $faculty->delete();

        return response()->noContent();
    }
}
