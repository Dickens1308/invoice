<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     * @noinspection PhpUnused
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
     * @return Response|bool
     */
    public function view(User $user): Response|bool
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
     * @return Response|bool
     */
    public function update(User $user): Response|bool
    {
        return $user->hasRole(['admin', 'staff']) ?
            Response::allow() :
            Response::deny("You don't have permission to update customer");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @return Response|bool
     */
    public function delete(User $user): Response|bool
    {
        return $user->hasRole('admin') ?
            Response::allow() :
            Response::deny("You don't have permission");
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @return Response|bool
     */
    public function restore(User $user): Response|bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @return Response|bool
     */
    public function forceDelete(User $user): Response|bool
    {
        return $user->hasRole('admin') ?
            Response::allow() :
            Response::deny("You don't have permission");
    }
}
