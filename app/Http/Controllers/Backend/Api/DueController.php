<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Due;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\DueResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\DueCollection;
use App\Http\Requests\DueStoreRequest;
use App\Http\Requests\DueUpdateRequest;

class DueController extends Controller
{
    public function index(Request $request): DueCollection
    {
        $this->authorize('view-any', Due::class);

        $search = $request->get('search', '');

        $dues = Due::search($search)
            ->latest()
            ->paginate();

        return new DueCollection($dues);
    }

    public function store(DueStoreRequest $request): DueResource
    {
        $this->authorize('create', Due::class);

        $validated = $request->validated();

        $due = Due::create($validated);

        return new DueResource($due);
    }

    public function show(Request $request, Due $due): DueResource
    {
        $this->authorize('view', $due);

        return new DueResource($due);
    }

    public function update(DueUpdateRequest $request, Due $due): DueResource
    {
        $this->authorize('update', $due);

        $validated = $request->validated();

        $due->update($validated);

        return new DueResource($due);
    }

    public function destroy(Request $request, Due $due): Response
    {
        $this->authorize('delete', $due);

        $due->delete();

        return response()->noContent();
    }
}
