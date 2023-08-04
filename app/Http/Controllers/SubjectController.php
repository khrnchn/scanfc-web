<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Faculty;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SubjectStoreRequest;
use App\Http\Requests\SubjectUpdateRequest;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Subject::class);

        $search = $request->get('search', '');

        $subjects = Subject::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.subjects.index', compact('subjects', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Subject::class);

        $faculties = Faculty::pluck('name', 'id');

        return view('app.subjects.create', compact('faculties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Subject::class);

        $validated = $request->validated();

        $subject = Subject::create($validated);

        return redirect()
            ->route('subjects.edit', $subject)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Subject $subject): View
    {
        $this->authorize('view', $subject);

        return view('app.subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Subject $subject): View
    {
        $this->authorize('update', $subject);

        $faculties = Faculty::pluck('name', 'id');

        return view('app.subjects.edit', compact('subject', 'faculties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SubjectUpdateRequest $request,
        Subject $subject
    ): RedirectResponse {
        $this->authorize('update', $subject);

        $validated = $request->validated();

        $subject->update($validated);

        return redirect()
            ->route('subjects.edit', $subject)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Subject $subject
    ): RedirectResponse {
        $this->authorize('delete', $subject);

        $subject->delete();

        return redirect()
            ->route('subjects.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
