<?php

namespace App\Policies;

use App\Constants\PermissionSlug;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionSlug::USERS_VIEW_ANY);
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasPermissionTo(PermissionSlug::USERS_VIEW);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionSlug::USERS_CREATE);
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasPermissionTo(PermissionSlug::USERS_UPDATE);
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasPermissionTo(PermissionSlug::USERS_DELETE);
    }
}
