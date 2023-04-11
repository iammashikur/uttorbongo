<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Resources\DueResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\DueCollection;

class BuyerDuesController extends Controller
{
    public function index(Request $request, Buyer $buyer): DueCollection
    {
        $this->authorize('view', $buyer);

        $search = $request->get('search', '');

        $dues = $buyer
            ->dues()
            ->search($search)
            ->latest()
            ->paginate();

        return new DueCollection($dues);
    }

    public function store(Request $request, Buyer $buyer): DueResource
    {
        $this->authorize('create', Due::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'product_code_id' => ['required', 'exists:product_codes,id'],
            'due_amount' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $due = $buyer->dues()->create($validated);

        return new DueResource($due);
    }
}
