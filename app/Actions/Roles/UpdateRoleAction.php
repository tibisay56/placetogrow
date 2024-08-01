<?php

namespace App\Actions\Roles;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdateRoleAction
{
    public function execute(Role $role, array $data): Role
    {
        $role->update(['name' => $data['name']]);
        $permissions = Permission::all()->filter(function($permission) use ($data) {
            return in_array($permission->id, $data['permissions']);
        });
        $role->syncPermissions($permissions);

        return $role;
    }
}
