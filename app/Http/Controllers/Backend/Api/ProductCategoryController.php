<?php

namespace App\Http\Controllers\Backend\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductCategoryCollection;
use App\Http\Requests\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;

class ProductCategoryController extends Controller
{
    public function index(Request $request): ProductCategoryCollection
    {
        $this->authorize('view-any', ProductCategory::class);

        $search = $request->get('search', '');

        $productCategories = ProductCategory::search($search)
            ->latest()
            ->paginate();

        return new ProductCategoryCollection($productCategories);
    }

    public function store(
        ProductCategoryStoreRequest $request
    ): ProductCategoryResource {
        $this->authorize('create', ProductCategory::class);

        $validated = $request->validated();

        $productCategory = ProductCategory::create($validated);

        return new ProductCategoryResource($productCategory);
    }

    public function show(
        Request $request,
        ProductCategory $productCategory
    ): ProductCategoryResource {
        $this->authorize('view', $productCategory);

        return new ProductCategoryResource($productCategory);
    }

    public function update(
        ProductCategoryUpdateRequest $request,
        ProductCategory $productCategory
    ): ProductCategoryResource {
        $this->authorize('update', $productCategory);

        $validated = $request->validated();

        $productCategory->update($validated);

        return new ProductCategoryResource($productCategory);
    }

    public function destroy(
        Request $request,
        ProductCategory $productCategory
    ): Response {
        $this->authorize('delete', $productCategory);

        $productCategory->delete();

        return response()->noContent();
    }
}
