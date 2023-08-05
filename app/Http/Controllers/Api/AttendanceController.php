<?php

namespace App\Http\Controllers\Api;

use App\Enums\ExemptionStatusEnum;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image as ImageIntervention;

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
            return $this->return_paginated_api(true, Response::HTTP_OK, 'No attendance history.', AttendanceResource::collection($data), null, $this->apiPaginator($data));
        }

        // Return the attendances as a resource collection
        return $this->return_paginated_api(true, Response::HTTP_OK, null, AttendanceResource::collection($data), null, $this->apiPaginator($data));
    }

    public function upload_exemption(Request $request, Attendance $attendance)
    {
        try {
            // Validate the file input
            $request->validate([
                'exemption_file' => 'required|file|image|max:2048',
                'exemption_remarks' => 'nullable|string|max:255',
            ]);
        } catch (ValidationException $e) {
            return $this->return_api(false, Response::HTTP_BAD_REQUEST, 'Invalid file format or size.', null, null);
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Store the uploaded file in a designated directory (e.g., 'exemption_files')
            $imageFile = $request->file('exemption_file');
            $imagePath = $imageFile->getRealPath();
            $originalExtension = $imageFile->getClientOriginalExtension();

            $imageName = 'exemption_' . time() . '.png';

            $imgFile = ImageIntervention::make($imagePath);
            $imgFile =  $imgFile->resize(1080, 1080, function ($constraint) {
                $constraint->aspectRatio();
            });

            if ($originalExtension != ".png") {
                // Change image format to png
                $imgFile = $imgFile->encode('png');
            }

            $imgFile->resizeCanvas(1080, 1080)->save(Storage::disk('exemption')->path($imageName));

            $attendance->update([
                'exemption_status' => ExemptionStatusEnum::ExemptionSubmitted(),
                'exemption_file' => $imageName,
                'exemption_remarks' => $request->input('exemption_remarks'),
            ]);

            // Commit the database transaction if everything is successful
            DB::commit();

            return $this->return_api(true, Response::HTTP_OK, null, null, null);
        } catch (NotReadableException $e) {
            // Handle image processing error
            DB::rollBack();
            return $this->return_api(false, Response::HTTP_INTERNAL_SERVER_ERROR, 'Error processing image: ' . $e->getMessage(), null, null);
        } catch (\Exception $e) {
            // Handle other general exceptions
            DB::rollBack();
            return $this->return_api(false, Response::HTTP_INTERNAL_SERVER_ERROR, 'Error uploading exemption file: ' . $e->getMessage(), null, null);
        }
    }
}
