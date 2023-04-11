<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Resources\ShopResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShopCollection;

class BranchShopsController extends Controller
{
    public function index(Request $request, Branch $branch): ShopCollection
    {
        $this->authorize('view', $branch);

        $search = $request->get('search', '');

        $shops = $branch
            ->shops()
            ->search($search)
            ->latest()
            ->paginate();

        return new ShopCollection($shops);
    }

    public function store(Request $request, Branch $branch): ShopResource
    {
        $this->authorize('create', Shop::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'address' => ['nullable', 'max:255', 'string'],
        ]);

        $shop = $branch->shops()->create($validated);

        return new ShopResource($shop);
    }
}
