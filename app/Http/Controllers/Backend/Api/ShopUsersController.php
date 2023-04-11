<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;

class ShopUsersController extends Controller
{
    public function index(Request $request, Shop $shop): UserCollection
    {
        $this->authorize('view', $shop);

        $search = $request->get('search', '');

        $users = $shop
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(Request $request, Shop $shop): UserResource
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'photo' => ['nullable', 'file'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $user = $shop->users()->create($validated);

        $user->syncRoles($request->roles);

        return new UserResource($user);
    }
}
