<?php

namespace App\Http\Controllers\Backend\Api;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class ProductCategoryProductsController extends Controller
{
    public function index(
        Request $request,
        ProductCategory $productCategory
    ): ProductCollection {
        $this->authorize('view', $productCategory);

        $search = $request->get('search', '');

        $products = $productCategory
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    public function store(
        Request $request,
        ProductCategory $productCategory
    ): ProductResource {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'brand_id' => ['required', 'exists:brands,id'],
            'image' => ['nullable', 'image', 'max:1024'],
            'product_type' => ['required', 'max:255', 'string'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'seller_id' => ['nullable', 'exists:sellers,id'],
            'purchase_price' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'details' => ['nullable', 'max:255', 'string'],
            'show_on_website' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $product = $productCategory->products()->create($validated);

        return new ProductResource($product);
    }
}
