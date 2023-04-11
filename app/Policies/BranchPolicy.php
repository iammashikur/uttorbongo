<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the branch can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list branches');
    }

    /**
     * Determine whether the branch can view the model.
     */
    public function view(User $user, Branch $model): bool
    {
        return $user->hasPermissionTo('view branches');
    }

    /**
     * Determine whether the branch can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create branches');
    }

    /**
     * Determine whether the branch can update the model.
     */
    public function update(User $user, Branch $model): bool
    {
        return $user->hasPermissionTo('update branches');
    }

    /**
     * Determine whether the branch can delete the model.
     */
    public function delete(User $user, Branch $model): bool
    {
        return $user->hasPermissionTo('delete branches');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete branches');
    }

    /**
     * Determine whether the branch can restore the model.
     */
    public function restore(User $user, Branch $model): bool
    {
        return false;
    }

    /**
     * Determine whether the branch can permanently delete the model.
     */
    public function forceDelete(User $user, Branch $model): bool
    {
        return false;
    }
}
