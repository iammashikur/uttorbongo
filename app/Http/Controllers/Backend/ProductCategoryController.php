<?php

namespace App\Http\Controllers\Backend;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ProductCategory::class);

        $search = $request->get('search', '');

        $productCategories = ProductCategory::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'backend.product_categories.index',
            compact('productCategories', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ProductCategory::class);

        return view('backend.product_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        ProductCategoryStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', ProductCategory::class);

        $validated = $request->validated();

        $productCategory = ProductCategory::create($validated);

        return redirect()
            ->route('product-categories.edit', $productCategory)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        ProductCategory $productCategory
    ): View {
        $this->authorize('view', $productCategory);

        return view(
            'backend.product_categories.show',
            compact('productCategory')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        ProductCategory $productCategory
    ): View {
        $this->authorize('update', $productCategory);

        return view(
            'backend.product_categories.edit',
            compact('productCategory')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ProductCategoryUpdateRequest $request,
        ProductCategory $productCategory
    ): RedirectResponse {
        $this->authorize('update', $productCategory);

        $validated = $request->validated();

        $productCategory->update($validated);

        return redirect()
            ->route('product-categories.edit', $productCategory)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ProductCategory $productCategory
    ): RedirectResponse {
        $this->authorize('delete', $productCategory);

        $productCategory->delete();

        return redirect()
            ->route('product-categories.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
