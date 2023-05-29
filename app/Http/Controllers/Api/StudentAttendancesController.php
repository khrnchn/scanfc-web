<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Http\Resources\AttendanceCollection;

class StudentAttendancesController extends Controller
{
    public function index(
        Request $request,
        Student $student
    ): AttendanceCollection {
        $this->authorize('view', $student);

        $search = $request->get('search', '');

        $attendances = $student
            ->attendances()
            ->search($search)
            ->latest()
            ->paginate();

        return new AttendanceCollection($attendances);
    }

    public function store(
        Request $request,
        Student $student
    ): AttendanceResource {
        $this->authorize('create', Attendance::class);

        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'status' => ['required', 'max:255', 'string'],
        ]);

        $attendance = $student->attendances()->create($validated);

        return new AttendanceResource($attendance);
    }
}
