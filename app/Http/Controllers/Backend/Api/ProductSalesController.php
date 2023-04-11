<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\SaleResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\SaleCollection;

class ProductSalesController extends Controller
{
    public function index(Request $request, Product $product): SaleCollection
    {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $sales = $product
            ->sales()
            ->search($search)
            ->latest()
            ->paginate();

        return new SaleCollection($sales);
    }

    public function store(Request $request, Product $product): SaleResource
    {
        $this->authorize('create', Sale::class);

        $validated = $request->validate([
            'product_code_id' => ['required', 'exists:product_codes,id'],
            'buyer_id' => ['required', 'exists:buyers,id'],
            'purchase_price' => ['required', 'numeric'],
            'sale_price' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
            'shop_id' => ['required', 'exists:shops,id'],
        ]);

        $sale = $product->sales()->create($validated);

        return new SaleResource($sale);
    }
}
