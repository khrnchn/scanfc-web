<?php

namespace App\Http\Controllers\Api;

use App\Enums\AttendanceStatusEnum;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassroomResource;
use App\Http\Resources\ClassroomCollection;
use App\Http\Requests\ClassroomStoreRequest;
use App\Http\Requests\ClassroomUpdateRequest;
use App\Models\Attendance;
use App\Models\Enrollment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiPaginatorTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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

        $take = request()->get('take', 1000);

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

    public function attend_class(Request $request)
    {
        // Use "windows + v" command to paste clipboard contents into a temporary file
        exec('powershell.exe Get-Clipboard > clipboard.txt');

        // Read the contents of the temporary file
        $clipboardContents = file_get_contents('clipboard.txt');

        // Remove the temporary file
        unlink('clipboard.txt');

        // Trim and return the clipboard value
        $uuidFromClipboard = trim($clipboardContents);

        $student = auth()->user()->student;

        // Compare the clipboard UUID with the student's nfc_tag column
        if ($student && $uuidFromClipboard == $student->nfc_tag) {
            $classroomId = Route::current()->parameter('classroom');
            $sectionId = Classroom::where('id', $classroomId)->value('section_id');

            $enrollment = Enrollment::where([
                'section_id' => $sectionId,
                'student_id' => $student->id,
            ])->first();

            if ($enrollment) {
                $attendance = Attendance::create([
                    'classroom_id' => $classroomId,
                    'enrollment_id' => $enrollment->id,
                    'attendance_status' => AttendanceStatusEnum::Present(),
                ]);

                return response()->json(['message' => 'Attendance recorded successfully.', 'student' => $student], 200);
            } else {
                // Student not enrolled in the specified section, attendance failed.
                return response()->json(['message' => 'Attendance failed, student not enrolled in the specified section.'], 401);
            }
        } else {
            // UUID doesn't match or student not found, attendance failed.
            return response()->json(['message' => 'Attendance failed, UUID doesnt match or student not found.'], 401);
        }
    }
}
