<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\SaleResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\SaleCollection;
use App\Http\Requests\SaleStoreRequest;
use App\Http\Requests\SaleUpdateRequest;

class SaleController extends Controller
{
    public function index(Request $request): SaleCollection
    {
        $this->authorize('view-any', Sale::class);

        $search = $request->get('search', '');

        $sales = Sale::search($search)
            ->latest()
            ->paginate();

        return new SaleCollection($sales);
    }

    public function store(SaleStoreRequest $request): SaleResource
    {
        $this->authorize('create', Sale::class);

        $validated = $request->validated();

        $sale = Sale::create($validated);

        return new SaleResource($sale);
    }

    public function show(Request $request, Sale $sale): SaleResource
    {
        $this->authorize('view', $sale);

        return new SaleResource($sale);
    }

    public function update(SaleUpdateRequest $request, Sale $sale): SaleResource
    {
        $this->authorize('update', $sale);

        $validated = $request->validated();

        $sale->update($validated);

        return new SaleResource($sale);
    }

    public function destroy(Request $request, Sale $sale): Response
    {
        $this->authorize('delete', $sale);

        $sale->delete();

        return response()->noContent();
    }
}
