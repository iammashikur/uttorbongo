<?php

namespace App\Policies;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the shop can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list shops');
    }

    /**
     * Determine whether the shop can view the model.
     */
    public function view(User $user, Shop $model): bool
    {
        return $user->hasPermissionTo('view shops');
    }

    /**
     * Determine whether the shop can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create shops');
    }

    /**
     * Determine whether the shop can update the model.
     */
    public function update(User $user, Shop $model): bool
    {
        return $user->hasPermissionTo('update shops');
    }

    /**
     * Determine whether the shop can delete the model.
     */
    public function delete(User $user, Shop $model): bool
    {
        return $user->hasPermissionTo('delete shops');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete shops');
    }

    /**
     * Determine whether the shop can restore the model.
     */
    public function restore(User $user, Shop $model): bool
    {
        return false;
    }

    /**
     * Determine whether the shop can permanently delete the model.
     */
    public function forceDelete(User $user, Shop $model): bool
    {
        return false;
    }
}
