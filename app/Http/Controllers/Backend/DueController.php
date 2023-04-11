<?php

namespace App\Http\Controllers\Backend;

use App\Models\Due;
use App\Models\User;
use App\Models\Buyer;
use App\Models\Product;
use Illuminate\View\View;
use App\Models\ProductCode;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\DueStoreRequest;
use App\Http\Requests\DueUpdateRequest;

class DueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Due::class);

        $search = $request->get('search', '');

        $dues = Due::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('backend.dues.index', compact('dues', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Due::class);

        $buyers = Buyer::pluck('name', 'id');
        $products = Product::pluck('name', 'id');
        $productCodes = ProductCode::pluck('product_code', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'backend.dues.create',
            compact('buyers', 'products', 'productCodes', 'users')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DueStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Due::class);

        $validated = $request->validated();

        $due = Due::create($validated);

        return redirect()
            ->route('dues.edit', $due)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Due $due): View
    {
        $this->authorize('view', $due);

        return view('backend.dues.show', compact('due'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Due $due): View
    {
        $this->authorize('update', $due);

        $buyers = Buyer::pluck('name', 'id');
        $products = Product::pluck('name', 'id');
        $productCodes = ProductCode::pluck('product_code', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'backend.dues.edit',
            compact('due', 'buyers', 'products', 'productCodes', 'users')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        DueUpdateRequest $request,
        Due $due
    ): RedirectResponse {
        $this->authorize('update', $due);

        $validated = $request->validated();

        $due->update($validated);

        return redirect()
            ->route('dues.edit', $due)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Due $due): RedirectResponse
    {
        $this->authorize('delete', $due);

        $due->delete();

        return redirect()
            ->route('dues.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
