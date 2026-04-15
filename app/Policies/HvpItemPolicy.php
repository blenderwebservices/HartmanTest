<?php

namespace App\Policies;

use App\Models\HvpItem;
use App\Models\User;

class HvpItemPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, HvpItem $hvpItem): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, HvpItem $hvpItem): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, HvpItem $hvpItem): bool
    {
        return $user->isAdmin();
    }
}
