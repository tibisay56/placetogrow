<?php

namespace App\Policies;

use App\Constants\PermissionSlug;
use App\Models\Role;
use App\Models\User;

class RolePolicy
{

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionSlug::ROLES_VIEW_ANY);
    }

    public function view(User $user, Role $role): bool
    {
        return $user->hasPermissionTo(PermissionSlug::ROLES_VIEW);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionSlug::ROLES_CREATE);
    }

    public function update(User $user, Role $role): bool
    {
        return $user->hasPermissionTo(PermissionSlug::ROLES_UPDATE);
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->hasPermissionTo(PermissionSlug::ROLES_DELETE);
    }
}
