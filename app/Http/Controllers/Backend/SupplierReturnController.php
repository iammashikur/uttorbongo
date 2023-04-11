<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\SupplierReturn;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SupplierReturnStoreRequest;
use App\Http\Requests\SupplierReturnUpdateRequest;

class SupplierReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', SupplierReturn::class);

        $search = $request->get('search', '');

        $supplierReturns = SupplierReturn::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'backend.supplier_returns.index',
            compact('supplierReturns', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', SupplierReturn::class);

        $suppliers = Supplier::pluck('name', 'id');
        $products = Product::pluck('name', 'id');

        return view(
            'backend.supplier_returns.create',
            compact('suppliers', 'products')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierReturnStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', SupplierReturn::class);

        $validated = $request->validated();

        $supplierReturn = SupplierReturn::create($validated);

        return redirect()
            ->route('supplier-returns.edit', $supplierReturn)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, SupplierReturn $supplierReturn): View
    {
        $this->authorize('view', $supplierReturn);

        return view('backend.supplier_returns.show', compact('supplierReturn'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, SupplierReturn $supplierReturn): View
    {
        $this->authorize('update', $supplierReturn);

        $suppliers = Supplier::pluck('name', 'id');
        $products = Product::pluck('name', 'id');

        return view(
            'backend.supplier_returns.edit',
            compact('supplierReturn', 'suppliers', 'products')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SupplierReturnUpdateRequest $request,
        SupplierReturn $supplierReturn
    ): RedirectResponse {
        $this->authorize('update', $supplierReturn);

        $validated = $request->validated();

        $supplierReturn->update($validated);

        return redirect()
            ->route('supplier-returns.edit', $supplierReturn)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        SupplierReturn $supplierReturn
    ): RedirectResponse {
        $this->authorize('delete', $supplierReturn);

        $supplierReturn->delete();

        return redirect()
            ->route('supplier-returns.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
