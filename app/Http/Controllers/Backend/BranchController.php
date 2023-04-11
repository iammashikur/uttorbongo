<?php

namespace App\Http\Controllers\Backend;

use App\Models\Branch;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\BranchStoreRequest;
use App\Http\Requests\BranchUpdateRequest;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Branch::class);

        $search = $request->get('search', '');

        $branches = Branch::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('backend.branches.index', compact('branches', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Branch::class);

        return view('backend.branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Branch::class);

        $validated = $request->validated();

        $branch = Branch::create($validated);

        return redirect()
            ->route('branches.edit', $branch)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Branch $branch): View
    {
        $this->authorize('view', $branch);

        return view('backend.branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Branch $branch): View
    {
        $this->authorize('update', $branch);

        return view('backend.branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        BranchUpdateRequest $request,
        Branch $branch
    ): RedirectResponse {
        $this->authorize('update', $branch);

        $validated = $request->validated();

        $branch->update($validated);

        return redirect()
            ->route('branches.edit', $branch)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Branch $branch): RedirectResponse
    {
        $this->authorize('delete', $branch);

        $branch->delete();

        return redirect()
            ->route('branches.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
