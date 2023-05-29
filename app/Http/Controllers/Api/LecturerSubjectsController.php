<?php
namespace App\Http\Controllers\Api;

use App\Models\Subject;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectCollection;

class LecturerSubjectsController extends Controller
{
    public function index(
        Request $request,
        Lecturer $lecturer
    ): SubjectCollection {
        $this->authorize('view', $lecturer);

        $search = $request->get('search', '');

        $subjects = $lecturer
            ->subjects()
            ->search($search)
            ->latest()
            ->paginate();

        return new SubjectCollection($subjects);
    }

    public function store(
        Request $request,
        Lecturer $lecturer,
        Subject $subject
    ): Response {
        $this->authorize('update', $lecturer);

        $lecturer->subjects()->syncWithoutDetaching([$subject->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Lecturer $lecturer,
        Subject $subject
    ): Response {
        $this->authorize('update', $lecturer);

        $lecturer->subjects()->detach($subject);

        return response()->noContent();
    }
}
