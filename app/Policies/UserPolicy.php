<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ViewAny - users');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): Response|bool
    {
        return $this->create($user) || $this->update($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response|bool
    {
        return $user->hasPermissionTo('Create - users');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response|bool
    {
        return $user->hasPermissionTo('Update - users');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $userToCheck): Response|bool
    {
        return $user->id !== $userToCheck->id
            && $user->hasPermissionTo('Delete - users');
    }
}
