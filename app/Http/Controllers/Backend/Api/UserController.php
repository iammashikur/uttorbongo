<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function index(Request $request): UserCollection
    {
        $this->authorize('view-any', User::class);

        $search = $request->get('search', '');

        $users = User::search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(UserStoreRequest $request): UserResource
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $user = User::create($validated);

        $user->syncRoles($request->roles);

        return new UserResource($user);
    }

    public function show(Request $request, User $user): UserResource
    {
        $this->authorize('view', $user);

        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $this->authorize('update', $user);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete($user->photo);
            }

            $validated['photo'] = $request->file('photo')->store('public');
        }

        $user->update($validated);

        $user->syncRoles($request->roles);

        return new UserResource($user);
    }

    public function destroy(Request $request, User $user): Response
    {
        $this->authorize('delete', $user);

        if ($user->photo) {
            Storage::delete($user->photo);
        }

        $user->delete();

        return response()->noContent();
    }
}