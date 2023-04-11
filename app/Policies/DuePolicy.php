<?php

namespace App\Policies;

use App\Models\Due;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the due can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list dues');
    }

    /**
     * Determine whether the due can view the model.
     */
    public function view(User $user, Due $model): bool
    {
        return $user->hasPermissionTo('view dues');
    }

    /**
     * Determine whether the due can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create dues');
    }

    /**
     * Determine whether the due can update the model.
     */
    public function update(User $user, Due $model): bool
    {
        return $user->hasPermissionTo('update dues');
    }

    /**
     * Determine whether the due can delete the model.
     */
    public function delete(User $user, Due $model): bool
    {
        return $user->hasPermissionTo('delete dues');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete dues');
    }

    /**
     * Determine whether the due can restore the model.
     */
    public function restore(User $user, Due $model): bool
    {
        return false;
    }

    /**
     * Determine whether the due can permanently delete the model.
     */
    public function forceDelete(User $user, Due $model): bool
    {
        return false;
    }
}
