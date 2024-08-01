<?php

namespace App\Policies;

use App\Constants\PermissionSlug;
use App\Constants\PolicyName;
use App\Models\Site;
use App\Models\User;

class SitePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PolicyName::VIEW_ANY);
    }

    public function view(User $user, Site $site): bool
    {
        return $user->hasPermissionTo(PermissionSlug::SITES_VIEW);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionSlug::SITES_CREATE);
    }

    public function update(User $user, Site $site): bool
    {
        return $user->hasPermissionTo(PermissionSlug::SITES_UPDATE);
    }

    public function delete(User $user, Site $site): bool
    {
        return $user->hasPermissionTo(PermissionSlug::SITES_DELETE);
    }

}
