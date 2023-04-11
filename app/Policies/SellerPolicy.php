<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Seller;
use Illuminate\Auth\Access\HandlesAuthorization;

class SellerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the seller can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list sellers');
    }

    /**
     * Determine whether the seller can view the model.
     */
    public function view(User $user, Seller $model): bool
    {
        return $user->hasPermissionTo('view sellers');
    }

    /**
     * Determine whether the seller can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create sellers');
    }

    /**
     * Determine whether the seller can update the model.
     */
    public function update(User $user, Seller $model): bool
    {
        return $user->hasPermissionTo('update sellers');
    }

    /**
     * Determine whether the seller can delete the model.
     */
    public function delete(User $user, Seller $model): bool
    {
        return $user->hasPermissionTo('delete sellers');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete sellers');
    }

    /**
     * Determine whether the seller can restore the model.
     */
    public function restore(User $user, Seller $model): bool
    {
        return false;
    }

    /**
     * Determine whether the seller can permanently delete the model.
     */
    public function forceDelete(User $user, Seller $model): bool
    {
        return false;
    }
}
