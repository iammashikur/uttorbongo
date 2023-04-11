<?php

namespace App\Http\Controllers\Backend;

use App\Models\Shop;
use App\Models\Branch;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ShopStoreRequest;
use App\Http\Requests\ShopUpdateRequest;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Shop::class);

        $search = $request->get('search', '');

        $shops = Shop::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('backend.shops.index', compact('shops', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Shop::class);

        $branches = Branch::pluck('name', 'id');

        return view('backend.shops.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShopStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Shop::class);

        $validated = $request->validated();

        $shop = Shop::create($validated);

        return redirect()
            ->route('shops.edit', $shop)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Shop $shop): View
    {
        $this->authorize('view', $shop);

        return view('backend.shops.show', compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Shop $shop): View
    {
        $this->authorize('update', $shop);

        $branches = Branch::pluck('name', 'id');

        return view('backend.shops.edit', compact('shop', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ShopUpdateRequest $request,
        Shop $shop
    ): RedirectResponse {
        $this->authorize('update', $shop);

        $validated = $request->validated();

        $shop->update($validated);

        return redirect()
            ->route('shops.edit', $shop)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Shop $shop): RedirectResponse
    {
        $this->authorize('delete', $shop);

        $shop->delete();

        return redirect()
            ->route('shops.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
