<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\ShopResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShopCollection;
use App\Http\Requests\ShopStoreRequest;
use App\Http\Requests\ShopUpdateRequest;

class ShopController extends Controller
{
    public function index(Request $request): ShopCollection
    {
        $this->authorize('view-any', Shop::class);

        $search = $request->get('search', '');

        $shops = Shop::search($search)
            ->latest()
            ->paginate();

        return new ShopCollection($shops);
    }

    public function store(ShopStoreRequest $request): ShopResource
    {
        $this->authorize('create', Shop::class);

        $validated = $request->validated();

        $shop = Shop::create($validated);

        return new ShopResource($shop);
    }

    public function show(Request $request, Shop $shop): ShopResource
    {
        $this->authorize('view', $shop);

        return new ShopResource($shop);
    }

    public function update(ShopUpdateRequest $request, Shop $shop): ShopResource
    {
        $this->authorize('update', $shop);

        $validated = $request->validated();

        $shop->update($validated);

        return new ShopResource($shop);
    }

    public function destroy(Request $request, Shop $shop): Response
    {
        $this->authorize('delete', $shop);

        $shop->delete();

        return response()->noContent();
    }
}
