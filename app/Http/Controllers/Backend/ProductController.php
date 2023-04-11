<?php

namespace App\Http\Controllers\Backend;

use App\Models\Brand;
use App\Models\Seller;
use App\Models\Product;
use App\Models\ProductCode;
use App\Models\Supplier;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Product::class);

        $search = $request->get('search', '');

        $products = Product::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('backend.products.index', compact('products', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Product::class);

        $productCategories = ProductCategory::pluck('name', 'id');
        $brands = Brand::pluck('name', 'id');
        $suppliers = Supplier::pluck('name', 'id');
        $sellers = Seller::pluck('name', 'id');

        return view(
            'backend.products.create',
            compact('productCategories', 'brands', 'suppliers', 'sellers')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request): RedirectResponse
    {


        $this->authorize('create', Product::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $product = Product::create($validated);




        $codes = json_decode($request->codes);
        foreach ($codes as $item) {
            ProductCode::create([
                'product_id' => $product->id,
                'product_code' => $item->value,
            ]);
        }

        return redirect()
            ->route('products.edit', $product)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Product $product): View
    {
        $this->authorize('view', $product);

        return view('backend.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Product $product): View
    {
        $this->authorize('update', $product);

        $productCategories = ProductCategory::pluck('name', 'id');
        $brands = Brand::pluck('name', 'id');
        $suppliers = Supplier::pluck('name', 'id');
        $sellers = Seller::pluck('name', 'id');
        $codes = ProductCode::where('product_id', $product->id)->pluck('product_code')->toArray();
        $product->codes = implode(',', $codes);
        return view(
            'backend.products.edit',
            compact(
                'product',
                'productCategories',
                'brands',
                'codes',
                'suppliers',
                'sellers'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ProductUpdateRequest $request,
        Product $product
    ): RedirectResponse {
        $this->authorize('update', $product);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete($product->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $product->update($validated);

        ProductCode::where('product_id', $product->id)->delete();

        $codes = json_decode($request->codes);

        foreach ($codes as $item) {
            ProductCode::create([
                'product_id' => $product->id,
                'product_code' => $item->value,
            ]);
        }

        return redirect()
            ->route('products.edit', $product)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Product $product
    ): RedirectResponse {
        $this->authorize('delete', $product);

        if ($product->image) {
            Storage::delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
