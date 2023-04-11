<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\DueResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\DueCollection;

class UserDuesController extends Controller
{
    public function index(Request $request, User $user): DueCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $dues = $user
            ->dues()
            ->search($search)
            ->latest()
            ->paginate();

        return new DueCollection($dues);
    }

    public function store(Request $request, User $user): DueResource
    {
        $this->authorize('create', Due::class);

        $validated = $request->validate([
            'buyer_id' => ['required', 'exists:buyers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'product_code_id' => ['required', 'exists:product_codes,id'],
            'due_amount' => ['required', 'numeric'],
        ]);

        $due = $user->dues()->create($validated);

        return new DueResource($due);
    }
}
