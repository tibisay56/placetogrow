<?php

namespace App\Actions\Roles;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UpdateRoleAction
{
    public function execute(Role $role, array $data): Role
    {
        $role->update(['name' => $data['name']]);
        $permissions = Permission::whereIn('id', $data['permissions'])->get(['name'])->toArray();
        $role->syncPermissions($permissions);

        return $role;
    }
}