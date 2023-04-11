<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupplierPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the supplier can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list suppliers');
    }

    /**
     * Determine whether the supplier can view the model.
     */
    public function view(User $user, Supplier $model): bool
    {
        return $user->hasPermissionTo('view suppliers');
    }

    /**
     * Determine whether the supplier can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create suppliers');
    }

    /**
     * Determine whether the supplier can update the model.
     */
    public function update(User $user, Supplier $model): bool
    {
        return $user->hasPermissionTo('update suppliers');
    }

    /**
     * Determine whether the supplier can delete the model.
     */
    public function delete(User $user, Supplier $model): bool
    {
        return $user->hasPermissionTo('delete suppliers');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete suppliers');
    }

    /**
     * Determine whether the supplier can restore the model.
     */
    public function restore(User $user, Supplier $model): bool
    {
        return false;
    }

    /**
     * Determine whether the supplier can permanently delete the model.
     */
    public function forceDelete(User $user, Supplier $model): bool
    {
        return false;
    }
}
