<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any users.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can view the user.
     */
    public function view(User $user, User $model): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can create users.
     */
    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the user.
     */
    public function update(User $user, User $model): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the user.
     */
    public function delete(User $user, User $model): bool
    {
        // Prevent deleting superadmin
        if ($model->role === 'superadmin') {
            return false;
        }

        // Prevent self-deletion
        if ($user->id === $model->id) {
            return false;
        }

        return $user->isSuperAdmin();
    }

    /**
     * Custom method to check if user can update role.
     */
    public function updateRole(User $actor, User $target): bool
    {
        if ($target->role === 'superadmin') {
            return false;
        }

        if ($actor->id === $target->id) {
            return false;
        }

        return $actor->isSuperAdmin();
    }
}
