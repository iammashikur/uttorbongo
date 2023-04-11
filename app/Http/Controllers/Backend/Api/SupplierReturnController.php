<?php

namespace App\Http\Controllers\Backend\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SupplierReturn;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierReturnResource;
use App\Http\Resources\SupplierReturnCollection;
use App\Http\Requests\SupplierReturnStoreRequest;
use App\Http\Requests\SupplierReturnUpdateRequest;

class SupplierReturnController extends Controller
{
    public function index(Request $request): SupplierReturnCollection
    {
        $this->authorize('view-any', SupplierReturn::class);

        $search = $request->get('search', '');

        $supplierReturns = SupplierReturn::search($search)
            ->latest()
            ->paginate();

        return new SupplierReturnCollection($supplierReturns);
    }

    public function store(
        SupplierReturnStoreRequest $request
    ): SupplierReturnResource {
        $this->authorize('create', SupplierReturn::class);

        $validated = $request->validated();

        $supplierReturn = SupplierReturn::create($validated);

        return new SupplierReturnResource($supplierReturn);
    }

    public function show(
        Request $request,
        SupplierReturn $supplierReturn
    ): SupplierReturnResource {
        $this->authorize('view', $supplierReturn);

        return new SupplierReturnResource($supplierReturn);
    }

    public function update(
        SupplierReturnUpdateRequest $request,
        SupplierReturn $supplierReturn
    ): SupplierReturnResource {
        $this->authorize('update', $supplierReturn);

        $validated = $request->validated();

        $supplierReturn->update($validated);

        return new SupplierReturnResource($supplierReturn);
    }

    public function destroy(
        Request $request,
        SupplierReturn $supplierReturn
    ): Response {
        $this->authorize('delete', $supplierReturn);

        $supplierReturn->delete();

        return response()->noContent();
    }
}
