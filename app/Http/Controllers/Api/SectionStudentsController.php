<?php
namespace App\Http\Controllers\Api;

use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCollection;

class SectionStudentsController extends Controller
{
    public function index(Request $request, Section $section): StudentCollection
    {
        $this->authorize('view', $section);

        $search = $request->get('search', '');

        $students = $section
            ->students()
            ->search($search)
            ->latest()
            ->paginate();

        return new StudentCollection($students);
    }

    public function store(
        Request $request,
        Section $section,
        Student $student
    ): Response {
        $this->authorize('update', $section);

        $section->students()->syncWithoutDetaching([$student->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Section $section,
        Student $student
    ): Response {
        $this->authorize('update', $section);

        $section->students()->detach($student);

        return response()->noContent();
    }
}
