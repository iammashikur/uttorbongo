<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class SupplierProductsController extends Controller
{
    public function index(
        Request $request,
        Supplier $supplier
    ): ProductCollection {
        $this->authorize('view', $supplier);

        $search = $request->get('search', '');

        $products = $supplier
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    public function store(Request $request, Supplier $supplier): ProductResource
    {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'product_category_id' => [
                'required',
                'exists:product_categories,id',
            ],
            'brand_id' => ['required', 'exists:brands,id'],
            'image' => ['nullable', 'image', 'max:1024'],
            'product_type' => ['required', 'max:255', 'string'],
            'seller_id' => ['nullable', 'exists:sellers,id'],
            'purchase_price' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'details' => ['nullable', 'max:255', 'string'],
            'show_on_website' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $product = $supplier->products()->create($validated);

        return new ProductResource($product);
    }
}
