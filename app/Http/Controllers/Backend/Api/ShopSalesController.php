<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Resources\SaleResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\SaleCollection;

class ShopSalesController extends Controller
{
    public function index(Request $request, Shop $shop): SaleCollection
    {
        $this->authorize('view', $shop);

        $search = $request->get('search', '');

        $sales = $shop
            ->sales()
            ->search($search)
            ->latest()
            ->paginate();

        return new SaleCollection($sales);
    }

    public function store(Request $request, Shop $shop): SaleResource
    {
        $this->authorize('create', Sale::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'product_code_id' => ['required', 'exists:product_codes,id'],
            'buyer_id' => ['required', 'exists:buyers,id'],
            'purchase_price' => ['required', 'numeric'],
            'sale_price' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $sale = $shop->sales()->create($validated);

        return new SaleResource($sale);
    }
}
