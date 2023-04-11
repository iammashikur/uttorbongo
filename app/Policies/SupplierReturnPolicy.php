<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SupplierReturn;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupplierReturnPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the supplierReturn can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list supplierreturns');
    }

    /**
     * Determine whether the supplierReturn can view the model.
     */
    public function view(User $user, SupplierReturn $model): bool
    {
        return $user->hasPermissionTo('view supplierreturns');
    }

    /**
     * Determine whether the supplierReturn can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create supplierreturns');
    }

    /**
     * Determine whether the supplierReturn can update the model.
     */
    public function update(User $user, SupplierReturn $model): bool
    {
        return $user->hasPermissionTo('update supplierreturns');
    }

    /**
     * Determine whether the supplierReturn can delete the model.
     */
    public function delete(User $user, SupplierReturn $model): bool
    {
        return $user->hasPermissionTo('delete supplierreturns');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete supplierreturns');
    }

    /**
     * Determine whether the supplierReturn can restore the model.
     */
    public function restore(User $user, SupplierReturn $model): bool
    {
        return false;
    }

    /**
     * Determine whether the supplierReturn can permanently delete the model.
     */
    public function forceDelete(User $user, SupplierReturn $model): bool
    {
        return false;
    }
}
