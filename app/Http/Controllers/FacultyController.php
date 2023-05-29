<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\FacultyStoreRequest;
use App\Http\Requests\FacultyUpdateRequest;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Faculty::class);

        $search = $request->get('search', '');

        $faculties = Faculty::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.faculties.index', compact('faculties', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Faculty::class);

        return view('app.faculties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FacultyStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Faculty::class);

        $validated = $request->validated();

        $faculty = Faculty::create($validated);

        return redirect()
            ->route('faculties.edit', $faculty)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Faculty $faculty): View
    {
        $this->authorize('view', $faculty);

        return view('app.faculties.show', compact('faculty'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Faculty $faculty): View
    {
        $this->authorize('update', $faculty);

        return view('app.faculties.edit', compact('faculty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        FacultyUpdateRequest $request,
        Faculty $faculty
    ): RedirectResponse {
        $this->authorize('update', $faculty);

        $validated = $request->validated();

        $faculty->update($validated);

        return redirect()
            ->route('faculties.edit', $faculty)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Faculty $faculty
    ): RedirectResponse {
        $this->authorize('delete', $faculty);

        $faculty->delete();

        return redirect()
            ->route('faculties.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
