<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ResourcePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ViewAny - resources');
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
        return $user->hasPermissionTo('Create - resources');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response|bool
    {
        return $user->hasPermissionTo('Update - resources');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response|bool
    {
        return $user->hasPermissionTo('Delete - resources');
    }
}
