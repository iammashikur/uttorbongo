<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the product can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list products');
    }

    /**
     * Determine whether the product can view the model.
     */
    public function view(User $user, Product $model): bool
    {
        return $user->hasPermissionTo('view products');
    }

    /**
     * Determine whether the product can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create products');
    }

    /**
     * Determine whether the product can update the model.
     */
    public function update(User $user, Product $model): bool
    {
        return $user->hasPermissionTo('update products');
    }

    /**
     * Determine whether the product can delete the model.
     */
    public function delete(User $user, Product $model): bool
    {
        return $user->hasPermissionTo('delete products');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete products');
    }

    /**
     * Determine whether the product can restore the model.
     */
    public function restore(User $user, Product $model): bool
    {
        return false;
    }

    /**
     * Determine whether the product can permanently delete the model.
     */
    public function forceDelete(User $user, Product $model): bool
    {
        return false;
    }
}
