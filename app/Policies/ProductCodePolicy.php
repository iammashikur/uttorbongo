<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductCode;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductCodePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productCode can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list productcodes');
    }

    /**
     * Determine whether the productCode can view the model.
     */
    public function view(User $user, ProductCode $model): bool
    {
        return $user->hasPermissionTo('view productcodes');
    }

    /**
     * Determine whether the productCode can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create productcodes');
    }

    /**
     * Determine whether the productCode can update the model.
     */
    public function update(User $user, ProductCode $model): bool
    {
        return $user->hasPermissionTo('update productcodes');
    }

    /**
     * Determine whether the productCode can delete the model.
     */
    public function delete(User $user, ProductCode $model): bool
    {
        return $user->hasPermissionTo('delete productcodes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete productcodes');
    }

    /**
     * Determine whether the productCode can restore the model.
     */
    public function restore(User $user, ProductCode $model): bool
    {
        return false;
    }

    /**
     * Determine whether the productCode can permanently delete the model.
     */
    public function forceDelete(User $user, ProductCode $model): bool
    {
        return false;
    }
}
