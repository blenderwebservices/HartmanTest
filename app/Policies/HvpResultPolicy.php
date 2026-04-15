<?php

namespace App\Policies;

use App\Models\HvpResult;
use App\Models\User;

class HvpResultPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Everyone logged in can see the list (results will be scoped in the resource)
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, HvpResult $hvpResult): bool
    {
        return $user->isAdmin() || $user->id === $hvpResult->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, HvpResult $hvpResult): bool
    {
        return $user->isAdmin() || $user->id === $hvpResult->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, HvpResult $hvpResult): bool
    {
        return $user->isAdmin();
    }
}
