<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Section;
use App\Models\Lecturer;
use App\Models\Classroom;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ClassroomStoreRequest;
use App\Http\Requests\ClassroomUpdateRequest;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Classroom::class);

        $search = $request->get('search', '');

        $classrooms = Classroom::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.classrooms.index', compact('classrooms', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Classroom::class);

        $subjects = Subject::pluck('name', 'id');
        $sections = Section::pluck('name', 'id');
        $lecturers = Lecturer::pluck('staff_id', 'id');

        return view(
            'app.classrooms.create',
            compact('subjects', 'sections', 'lecturers')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassroomStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Classroom::class);

        $validated = $request->validated();

        $classroom = Classroom::create($validated);

        return redirect()
            ->route('classrooms.edit', $classroom)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Classroom $classroom): View
    {
        $this->authorize('view', $classroom);

        return view('app.classrooms.show', compact('classroom'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Classroom $classroom): View
    {
        $this->authorize('update', $classroom);

        $subjects = Subject::pluck('name', 'id');
        $sections = Section::pluck('name', 'id');
        $lecturers = Lecturer::pluck('staff_id', 'id');

        return view(
            'app.classrooms.edit',
            compact('classroom', 'subjects', 'sections', 'lecturers')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ClassroomUpdateRequest $request,
        Classroom $classroom
    ): RedirectResponse {
        $this->authorize('update', $classroom);

        $validated = $request->validated();

        $classroom->update($validated);

        return redirect()
            ->route('classrooms.edit', $classroom)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Classroom $classroom
    ): RedirectResponse {
        $this->authorize('delete', $classroom);

        $classroom->delete();

        return redirect()
            ->route('classrooms.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
