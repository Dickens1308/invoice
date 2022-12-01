<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->hasRole(['admin', 'staff', 'user']) ?
            Response::allow() :
            Response::deny("You don't have permission to create customer");
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Product $product
     * @return Response|bool
     */
    public function view(User $user, Product $product): Response|bool
    {
        return $user->hasRole(['admin', 'staff', 'user']) ?
            Response::allow() :
            Response::deny("You don't have permission to create customer");
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $user->hasRole(['admin', 'staff']) ?
            Response::allow() :
            Response::deny("You don't have permission to create customer");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Product $product
     * @return Response|bool
     */
    public function update(User $user, Product $product): Response|bool
    {
        return $user->hasRole(['admin', 'staff']) ?
            Response::allow() :
            Response::deny("You don't have permission to update customer");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Product $product
     * @return Response|bool
     */
    public function delete(User $user, Product $product): Response|bool
    {
        return $user->hasRole('admin') ?
            Response::allow() :
            Response::deny("You don't have permission");
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Product $product
     * @return Response|bool
     */
    public function restore(User $user, Product $product): Response|bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return $user->hasRole('admin') ?
            Response::allow() :
            Response::deny("You don't have permission");
    }
}
