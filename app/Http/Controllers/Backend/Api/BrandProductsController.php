<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class BrandProductsController extends Controller
{
    public function index(Request $request, Brand $brand): ProductCollection
    {
        $this->authorize('view', $brand);

        $search = $request->get('search', '');

        $products = $brand
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    public function store(Request $request, Brand $brand): ProductResource
    {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'product_category_id' => [
                'required',
                'exists:product_categories,id',
            ],
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

        $product = $brand->products()->create($validated);

        return new ProductResource($product);
    }
}
