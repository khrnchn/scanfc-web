<?php

namespace App\Http\Controllers\Api;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassroomResource;
use App\Http\Resources\ClassroomCollection;
use App\Http\Requests\ClassroomStoreRequest;
use App\Http\Requests\ClassroomUpdateRequest;

class ClassroomController extends Controller
{
    public function index(Request $request): ClassroomCollection
    {
        $this->authorize('view-any', Classroom::class);

        $search = $request->get('search', '');

        $classrooms = Classroom::search($search)
            ->latest()
            ->paginate();

        return new ClassroomCollection($classrooms);
    }

    public function store(ClassroomStoreRequest $request): ClassroomResource
    {
        $this->authorize('create', Classroom::class);

        $validated = $request->validated();

        $classroom = Classroom::create($validated);

        return new ClassroomResource($classroom);
    }

    public function show(
        Request $request,
        Classroom $classroom
    ): ClassroomResource {
        $this->authorize('view', $classroom);

        return new ClassroomResource($classroom);
    }

    public function update(
        ClassroomUpdateRequest $request,
        Classroom $classroom
    ): ClassroomResource {
        $this->authorize('update', $classroom);

        $validated = $request->validated();

        $classroom->update($validated);

        return new ClassroomResource($classroom);
    }

    public function destroy(Request $request, Classroom $classroom): Response
    {
        $this->authorize('delete', $classroom);

        $classroom->delete();

        return response()->noContent();
    }
}
