<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ComplaintPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ViewAny - complaints');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): Response|bool
    {
        return $this->update($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response|bool
    {
        return $user->hasPermissionTo('Update - complaints');
    }

}
