<?php

namespace App\Http\Controllers\Backend;

use App\Models\Brand;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Brand::class);

        $search = $request->get('search', '');

        $brands = Brand::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('backend.brands.index', compact('brands', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Brand::class);

        return view('backend.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Brand::class);

        $validated = $request->validated();

        $brand = Brand::create($validated);

        return redirect()
            ->route('brands.edit', $brand)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Brand $brand): View
    {
        $this->authorize('view', $brand);

        return view('backend.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Brand $brand): View
    {
        $this->authorize('update', $brand);

        return view('backend.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        BrandUpdateRequest $request,
        Brand $brand
    ): RedirectResponse {
        $this->authorize('update', $brand);

        $validated = $request->validated();

        $brand->update($validated);

        return redirect()
            ->route('brands.edit', $brand)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Brand $brand): RedirectResponse
    {
        $this->authorize('delete', $brand);

        $brand->delete();

        return redirect()
            ->route('brands.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
