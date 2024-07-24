<?php

namespace App\Actions\Roles;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class StoreRoleAction
{
    public function execute(array $data): Role
    {
        $role = Role::create(['name' => $data['name']]);
        $permissions = Permission::whereIn('id', $data['permissions'])->get(['name'])->toArray();
        $role->syncPermissions($permissions);

        return $role;
    }
}
