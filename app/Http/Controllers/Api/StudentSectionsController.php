<?php
namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\SectionCollection;

class StudentSectionsController extends Controller
{
    public function index(Request $request, Student $student): SectionCollection
    {
        $this->authorize('view', $student);

        $search = $request->get('search', '');

        $sections = $student
            ->sections()
            ->search($search)
            ->latest()
            ->paginate();

        return new SectionCollection($sections);
    }

    public function store(
        Request $request,
        Student $student,
        Section $section
    ): Response {
        $this->authorize('update', $student);

        $student->sections()->syncWithoutDetaching([$section->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Student $student,
        Section $section
    ): Response {
        $this->authorize('update', $student);

        $student->sections()->detach($section);

        return response()->noContent();
    }
}
