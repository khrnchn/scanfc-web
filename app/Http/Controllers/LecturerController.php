<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Lecturer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\LecturerStoreRequest;
use App\Http\Requests\LecturerUpdateRequest;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Lecturer::class);

        $search = $request->get('search', '');

        $lecturers = Lecturer::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.lecturers.index', compact('lecturers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Lecturer::class);

        $users = User::pluck('name', 'id');
        $faculties = Faculty::pluck('name', 'id');

        return view('app.lecturers.create', compact('users', 'faculties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LecturerStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Lecturer::class);

        $validated = $request->validated();

        $lecturer = Lecturer::create($validated);

        return redirect()
            ->route('lecturers.edit', $lecturer)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Lecturer $lecturer): View
    {
        $this->authorize('view', $lecturer);

        return view('app.lecturers.show', compact('lecturer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Lecturer $lecturer): View
    {
        $this->authorize('update', $lecturer);

        $users = User::pluck('name', 'id');
        $faculties = Faculty::pluck('name', 'id');

        return view(
            'app.lecturers.edit',
            compact('lecturer', 'users', 'faculties')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        LecturerUpdateRequest $request,
        Lecturer $lecturer
    ): RedirectResponse {
        $this->authorize('update', $lecturer);

        $validated = $request->validated();

        $lecturer->update($validated);

        return redirect()
            ->route('lecturers.edit', $lecturer)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Lecturer $lecturer
    ): RedirectResponse {
        $this->authorize('delete', $lecturer);

        $lecturer->delete();

        return redirect()
            ->route('lecturers.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
