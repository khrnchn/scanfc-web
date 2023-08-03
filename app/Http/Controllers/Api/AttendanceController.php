<?php

namespace App\Http\Controllers\Api;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Http\Resources\AttendanceCollection;
use App\Http\Requests\AttendanceStoreRequest;
use App\Http\Requests\AttendanceUpdateRequest;
use App\Models\Enrollment;
use App\Traits\ApiPaginatorTrait;

class AttendanceController extends Controller
{
    use ApiPaginatorTrait;

    public function index(Request $request): AttendanceCollection
    {
        $this->authorize('view-any', Attendance::class);

        $search = $request->get('search', '');

        $attendances = Attendance::search($search)
            ->latest()
            ->paginate();

        return new AttendanceCollection($attendances);
    }

    public function store(AttendanceStoreRequest $request): AttendanceResource
    {
        $this->authorize('create', Attendance::class);

        $validated = $request->validated();

        $attendance = Attendance::create($validated);

        return new AttendanceResource($attendance);
    }

    public function show(
        Request $request,
        Attendance $attendance
    ): AttendanceResource {
        $this->authorize('view', $attendance);

        return new AttendanceResource($attendance);
    }

    public function update(
        AttendanceUpdateRequest $request,
        Attendance $attendance
    ): AttendanceResource {
        $this->authorize('update', $attendance);

        $validated = $request->validated();

        $attendance->update($validated);

        return new AttendanceResource($attendance);
    }

    public function destroy(Request $request, Attendance $attendance): Response
    {
        $this->authorize('delete', $attendance);

        $attendance->delete();

        return response()->noContent();
    }

    public function history()
    {
        // Get the authenticated student
        $student = auth()->user()->student;

        $enrollments = Enrollment::where('student_id', $student->id)->get();

        // Get the IDs of all enrollments
        $enrollmentIds = $enrollments->pluck('id')->toArray();

        // Get the attendances that have enrollment_id matching any of the enrollment IDs
        $data = Attendance::whereIn('enrollment_id', $enrollmentIds)->latest()->paginate(request()->get('take', 1000));

        // Check if data is empty
        if ($data->isEmpty()) {
            return response()->json(['message' => 'No history of attendance found.'], Response::HTTP_OK);
        }

        // Return the attendances as a resource collection
        return $this->return_paginated_api(true, Response::HTTP_OK, null, AttendanceResource::collection($data), null, $this->apiPaginator($data));
    }
}
