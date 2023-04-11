<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierReturnResource;
use App\Http\Resources\SupplierReturnCollection;

class SupplierSupplierReturnsController extends Controller
{
    public function index(
        Request $request,
        Supplier $supplier
    ): SupplierReturnCollection {
        $this->authorize('view', $supplier);

        $search = $request->get('search', '');

        $supplierReturns = $supplier
            ->supplierReturns()
            ->search($search)
            ->latest()
            ->paginate();

        return new SupplierReturnCollection($supplierReturns);
    }

    public function store(
        Request $request,
        Supplier $supplier
    ): SupplierReturnResource {
        $this->authorize('create', SupplierReturn::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $supplierReturn = $supplier->supplierReturns()->create($validated);

        return new SupplierReturnResource($supplierReturn);
    }
}
