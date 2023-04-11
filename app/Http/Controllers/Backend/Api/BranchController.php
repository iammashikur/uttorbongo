<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchResource;
use App\Http\Resources\BranchCollection;
use App\Http\Requests\BranchStoreRequest;
use App\Http\Requests\BranchUpdateRequest;

class BranchController extends Controller
{
    public function index(Request $request): BranchCollection
    {
        $this->authorize('view-any', Branch::class);

        $search = $request->get('search', '');

        $branches = Branch::search($search)
            ->latest()
            ->paginate();

        return new BranchCollection($branches);
    }

    public function store(BranchStoreRequest $request): BranchResource
    {
        $this->authorize('create', Branch::class);

        $validated = $request->validated();

        $branch = Branch::create($validated);

        return new BranchResource($branch);
    }

    public function show(Request $request, Branch $branch): BranchResource
    {
        $this->authorize('view', $branch);

        return new BranchResource($branch);
    }

    public function update(
        BranchUpdateRequest $request,
        Branch $branch
    ): BranchResource {
        $this->authorize('update', $branch);

        $validated = $request->validated();

        $branch->update($validated);

        return new BranchResource($branch);
    }

    public function destroy(Request $request, Branch $branch): Response
    {
        $this->authorize('delete', $branch);

        $branch->delete();

        return response()->noContent();
    }
}
