<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\SellerResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SellerCollection;
use App\Http\Requests\SellerStoreRequest;
use App\Http\Requests\SellerUpdateRequest;

class SellerController extends Controller
{
    public function index(Request $request): SellerCollection
    {
        $this->authorize('view-any', Seller::class);

        $search = $request->get('search', '');

        $sellers = Seller::search($search)
            ->latest()
            ->paginate();

        return new SellerCollection($sellers);
    }

    public function store(SellerStoreRequest $request): SellerResource
    {
        $this->authorize('create', Seller::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('document')) {
            $validated['document'] = $request
                ->file('document')
                ->store('public');
        }

        $seller = Seller::create($validated);

        return new SellerResource($seller);
    }

    public function show(Request $request, Seller $seller): SellerResource
    {
        $this->authorize('view', $seller);

        return new SellerResource($seller);
    }

    public function update(
        SellerUpdateRequest $request,
        Seller $seller
    ): SellerResource {
        $this->authorize('update', $seller);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($seller->image) {
                Storage::delete($seller->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('document')) {
            if ($seller->document) {
                Storage::delete($seller->document);
            }

            $validated['document'] = $request
                ->file('document')
                ->store('public');
        }

        $seller->update($validated);

        return new SellerResource($seller);
    }

    public function destroy(Request $request, Seller $seller): Response
    {
        $this->authorize('delete', $seller);

        if ($seller->image) {
            Storage::delete($seller->image);
        }

        if ($seller->document) {
            Storage::delete($seller->document);
        }

        $seller->delete();

        return response()->noContent();
    }
}
