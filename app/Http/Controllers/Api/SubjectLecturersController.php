<?php
namespace App\Http\Controllers\Api;

use App\Models\Subject;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\LecturerCollection;

class SubjectLecturersController extends Controller
{
    public function index(
        Request $request,
        Subject $subject
    ): LecturerCollection {
        $this->authorize('view', $subject);

        $search = $request->get('search', '');

        $lecturers = $subject
            ->lecturers()
            ->search($search)
            ->latest()
            ->paginate();

        return new LecturerCollection($lecturers);
    }

    public function store(
        Request $request,
        Subject $subject,
        Lecturer $lecturer
    ): Response {
        $this->authorize('update', $subject);

        $subject->lecturers()->syncWithoutDetaching([$lecturer->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Subject $subject,
        Lecturer $lecturer
    ): Response {
        $this->authorize('update', $subject);

        $subject->lecturers()->detach($lecturer);

        return response()->noContent();
    }
}
