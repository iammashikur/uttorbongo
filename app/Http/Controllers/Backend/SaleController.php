<?php

namespace App\Http\Controllers\Backend;

use App\Models\Sale;
use App\Models\User;
use App\Models\Shop;
use App\Models\Buyer;
use App\Models\Product;
use Illuminate\View\View;
use App\Models\ProductCode;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SaleStoreRequest;
use App\Http\Requests\SaleUpdateRequest;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Sale::class);

        $search = $request->get('search', '');

        $sales = Sale::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('backend.sales.index', compact('sales', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Sale::class);

        $products = Product::pluck('name', 'id');
        $productCodes = ProductCode::pluck('product_code', 'id');
        $buyers = Buyer::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $shops = Shop::pluck('name', 'id');

        return view(
            'backend.sales.create',
            compact('products', 'productCodes', 'buyers', 'users', 'shops')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Sale::class);

        $validated = $request->validated();

        $sale = Sale::create($validated);

        return redirect()
            ->route('sales.edit', $sale)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Sale $sale): View
    {
        $this->authorize('view', $sale);

        return view('backend.sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Sale $sale): View
    {
        $this->authorize('update', $sale);

        $products = Product::pluck('name', 'id');
        $productCodes = ProductCode::pluck('product_code', 'id');
        $buyers = Buyer::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $shops = Shop::pluck('name', 'id');

        return view(
            'backend.sales.edit',
            compact(
                'sale',
                'products',
                'productCodes',
                'buyers',
                'users',
                'shops'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SaleUpdateRequest $request,
        Sale $sale
    ): RedirectResponse {
        $this->authorize('update', $sale);

        $validated = $request->validated();

        $sale->update($validated);

        return redirect()
            ->route('sales.edit', $sale)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Sale $sale): RedirectResponse
    {
        $this->authorize('delete', $sale);

        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
