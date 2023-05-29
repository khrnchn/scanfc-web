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

class AttendanceController extends Controller
{
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
}
