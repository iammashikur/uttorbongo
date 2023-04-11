<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\DueResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\DueCollection;

class ProductDuesController extends Controller
{
    public function index(Request $request, Product $product): DueCollection
    {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $dues = $product
            ->dues()
            ->search($search)
            ->latest()
            ->paginate();

        return new DueCollection($dues);
    }

    public function store(Request $request, Product $product): DueResource
    {
        $this->authorize('create', Due::class);

        $validated = $request->validate([
            'buyer_id' => ['required', 'exists:buyers,id'],
            'product_code_id' => ['required', 'exists:product_codes,id'],
            'due_amount' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $due = $product->dues()->create($validated);

        return new DueResource($due);
    }
}
