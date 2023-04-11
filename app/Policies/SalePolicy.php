<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the sale can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list sales');
    }

    /**
     * Determine whether the sale can view the model.
     */
    public function view(User $user, Sale $model): bool
    {
        return $user->hasPermissionTo('view sales');
    }

    /**
     * Determine whether the sale can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create sales');
    }

    /**
     * Determine whether the sale can update the model.
     */
    public function update(User $user, Sale $model): bool
    {
        return $user->hasPermissionTo('update sales');
    }

    /**
     * Determine whether the sale can delete the model.
     */
    public function delete(User $user, Sale $model): bool
    {
        return $user->hasPermissionTo('delete sales');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete sales');
    }

    /**
     * Determine whether the sale can restore the model.
     */
    public function restore(User $user, Sale $model): bool
    {
        return false;
    }

    /**
     * Determine whether the sale can permanently delete the model.
     */
    public function forceDelete(User $user, Sale $model): bool
    {
        return false;
    }
}
