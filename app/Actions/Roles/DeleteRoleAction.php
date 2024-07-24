<?php

namespace App\Actions\Roles;

use Spatie\Permission\Models\Role;

class DeleteRoleAction
{
    public function execute(Role $role): void
    {
        $role->delete();
    }
}
