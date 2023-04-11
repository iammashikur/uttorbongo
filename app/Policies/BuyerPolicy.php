<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Buyer;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuyerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the buyer can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list buyers');
    }

    /**
     * Determine whether the buyer can view the model.
     */
    public function view(User $user, Buyer $model): bool
    {
        return $user->hasPermissionTo('view buyers');
    }

    /**
     * Determine whether the buyer can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create buyers');
    }

    /**
     * Determine whether the buyer can update the model.
     */
    public function update(User $user, Buyer $model): bool
    {
        return $user->hasPermissionTo('update buyers');
    }

    /**
     * Determine whether the buyer can delete the model.
     */
    public function delete(User $user, Buyer $model): bool
    {
        return $user->hasPermissionTo('delete buyers');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete buyers');
    }

    /**
     * Determine whether the buyer can restore the model.
     */
    public function restore(User $user, Buyer $model): bool
    {
        return false;
    }

    /**
     * Determine whether the buyer can permanently delete the model.
     */
    public function forceDelete(User $user, Buyer $model): bool
    {
        return false;
    }
}
