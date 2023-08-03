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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiPaginatorTrait;
use Illuminate\Support\Facades\Log;

class ClassroomController extends Controller
{
    use ApiPaginatorTrait;

    public function index(Request $request): ClassroomCollection
    {
        $this->authorize('view-any', Classroom::class);

        $classrooms = Classroom::latest()
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

    public function classrooms(Request $request)
    {
        $data = new Classroom;

        $user = Auth::user();
        $student = $user->student;

        if ($student) {
            $sections = $student->sections->pluck('id');
            $data = $data->whereIn('section_id', $sections);
        }

        $today = Carbon::today();
        $data = $data->whereDate('start_at', $today);

        $data = $data->paginate();

        return $this->return_paginated_api(true, Response::HTTP_OK, null, ClassroomResource::collection($data), null, $this->apiPaginator($data));
    }
}
