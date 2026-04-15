<?php

namespace App\Policies;

use App\Models\AiProvider;
use App\Models\User;

class AiProviderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, AiProvider $aiProvider): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, AiProvider $aiProvider): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, AiProvider $aiProvider): bool
    {
        return $user->isAdmin();
    }
}
