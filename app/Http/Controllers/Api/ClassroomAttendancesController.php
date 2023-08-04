<?php

namespace App\Http\Controllers\Api;

use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Http\Resources\AttendanceCollection;

class ClassroomAttendancesController extends Controller
{
    public function index(
        Request $request,
        Classroom $classroom
    ): AttendanceCollection {
        $this->authorize('view', $classroom);

        $search = $request->get('search', '');

        $attendances = $classroom
            ->attendances()
            ->search($search)
            ->latest()
            ->paginate();

        return new AttendanceCollection($attendances);
    }

    public function store(
        Request $request,
        Classroom $classroom
    ): AttendanceResource {
        $this->authorize('create', Attendance::class);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'status' => ['required', 'max:255', 'string'],
        ]);

        $attendance = $classroom->attendances()->create($validated);

        return new AttendanceResource($attendance);
    }
}
