<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(Request $request): StudentCollection
    {
        $this->authorize('view-any', Student::class);

        $search = $request->get('search', '');

        $students = Student::search($search)
            ->latest()
            ->paginate();

        return new StudentCollection($students);
    }

    public function store(StudentStoreRequest $request): StudentResource
    {
        $this->authorize('create', Student::class);

        $validated = $request->validated();

        $student = Student::create($validated);

        return new StudentResource($student);
    }

    public function show(Request $request, Student $student): StudentResource
    {
        $this->authorize('view', $student);

        return new StudentResource($student);
    }

    public function update(
        StudentUpdateRequest $request,
        Student $student
    ): StudentResource {
        $this->authorize('update', $student);

        $validated = $request->validated();

        $student->update($validated);

        return new StudentResource($student);
    }

    public function destroy(Request $request, Student $student): Response
    {
        $this->authorize('delete', $student);

        $student->delete();

        return response()->noContent();
    }

    public function registerNfc(Student $student, Request $request)
    {
        $student = auth()->user()->student;

        // Validate the input data
        $validator = Validator::make($request->all(), [
            'uuid' => 'required|string', // Add any other validation rules specific to your UUID format
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return $this->return_api(false, Response::HTTP_BAD_REQUEST, 'Invalid input data', $validator->errors(), null);
        }

        // Get the UUID from the request
        $uuid = $request->get('uuid');

        // Update the student's NFC tag
        $student->update(['nfc_tag' => $uuid]);

        return $this->return_api(true, Response::HTTP_OK, 'Successfully registered NFC tag', ['uuid' => $uuid], null);
    }

    public function getNfcTag(Student $student)
    {
        $nfc_tag = $student->nfc_tag;

        return $this->return_api(true, Response::HTTP_OK, 'NFC tag retrieved successfully', ['nfc_tag' => $nfc_tag], null);
    }
}
