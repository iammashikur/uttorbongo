<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierReturnResource;
use App\Http\Resources\SupplierReturnCollection;

class ProductSupplierReturnsController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): SupplierReturnCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $supplierReturns = $product
            ->supplierReturns()
            ->search($search)
            ->latest()
            ->paginate();

        return new SupplierReturnCollection($supplierReturns);
    }

    public function store(
        Request $request,
        Product $product
    ): SupplierReturnResource {
        $this->authorize('create', SupplierReturn::class);

        $validated = $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
        ]);

        $supplierReturn = $product->supplierReturns()->create($validated);

        return new SupplierReturnResource($supplierReturn);
    }
}
