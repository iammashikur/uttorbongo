<?php

namespace App\Http\Controllers\Backend;

use App\Models\Seller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SellerStoreRequest;
use App\Http\Requests\SellerUpdateRequest;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Seller::class);

        $search = $request->get('search', '');

        $sellers = Seller::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('backend.sellers.index', compact('sellers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Seller::class);

        return view('backend.sellers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SellerStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Seller::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('document')) {
            $validated['document'] = $request
                ->file('document')
                ->store('public');
        }

        $seller = Seller::create($validated);

        return redirect()
            ->route('sellers.edit', $seller)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Seller $seller): View
    {
        $this->authorize('view', $seller);

        return view('backend.sellers.show', compact('seller'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Seller $seller): View
    {
        $this->authorize('update', $seller);

        return view('backend.sellers.edit', compact('seller'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SellerUpdateRequest $request,
        Seller $seller
    ): RedirectResponse {
        $this->authorize('update', $seller);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($seller->image) {
                Storage::delete($seller->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('document')) {
            if ($seller->document) {
                Storage::delete($seller->document);
            }

            $validated['document'] = $request
                ->file('document')
                ->store('public');
        }

        $seller->update($validated);

        return redirect()
            ->route('sellers.edit', $seller)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Seller $seller): RedirectResponse
    {
        $this->authorize('delete', $seller);

        if ($seller->image) {
            Storage::delete($seller->image);
        }

        if ($seller->document) {
            Storage::delete($seller->document);
        }

        $seller->delete();

        return redirect()
            ->route('sellers.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
