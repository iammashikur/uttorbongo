<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\SaleResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\SaleCollection;

class UserSalesController extends Controller
{
    public function index(Request $request, User $user): SaleCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $sales = $user
            ->sales()
            ->search($search)
            ->latest()
            ->paginate();

        return new SaleCollection($sales);
    }

    public function store(Request $request, User $user): SaleResource
    {
        $this->authorize('create', Sale::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'product_code_id' => ['required', 'exists:product_codes,id'],
            'buyer_id' => ['required', 'exists:buyers,id'],
            'purchase_price' => ['required', 'numeric'],
            'sale_price' => ['required', 'numeric'],
            'shop_id' => ['required', 'exists:shops,id'],
        ]);

        $sale = $user->sales()->create($validated);

        return new SaleResource($sale);
    }
}
