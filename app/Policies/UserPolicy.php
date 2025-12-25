<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function updateRole(User $actor, User $target): bool
    {
        if ($target->role === 'superadmin') {
            return false;
        }

        if ($actor->id === $target->id) {
            return false;
        }

        return $actor->role === 'superadmin';
    }

    public function delete(User $actor, User $target): bool
    {
        if ($target->role === 'superadmin') {
            return false;
        }

        if ($actor->id === $target->id) {
            return false;
        }

        return $actor->role === 'superadmin';
    }
}
