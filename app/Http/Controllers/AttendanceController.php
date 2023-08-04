<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\View\View;
use App\Models\Classroom;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\AttendanceStoreRequest;
use App\Http\Requests\AttendanceUpdateRequest;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Attendance::class);

        $search = $request->get('search', '');

        $attendances = Attendance::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.attendances.index', compact('attendances', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Attendance::class);

        $students = Student::pluck('matrix_id', 'id');
        $classrooms = Classroom::pluck('name', 'id');

        return view(
            'app.attendances.create',
            compact('students', 'classrooms')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttendanceStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Attendance::class);

        $validated = $request->validated();

        $attendance = Attendance::create($validated);

        return redirect()
            ->route('attendances.edit', $attendance)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Attendance $attendance): View
    {
        $this->authorize('view', $attendance);

        return view('app.attendances.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Attendance $attendance): View
    {
        $this->authorize('update', $attendance);

        $students = Student::pluck('matrix_id', 'id');
        $classrooms = Classroom::pluck('name', 'id');

        return view(
            'app.attendances.edit',
            compact('attendance', 'students', 'classrooms')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        AttendanceUpdateRequest $request,
        Attendance $attendance
    ): RedirectResponse {
        $this->authorize('update', $attendance);

        $validated = $request->validated();

        $attendance->update($validated);

        return redirect()
            ->route('attendances.edit', $attendance)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Attendance $attendance
    ): RedirectResponse {
        $this->authorize('delete', $attendance);

        $attendance->delete();

        return redirect()
            ->route('attendances.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
