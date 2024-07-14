<?php

namespace Database\Seeders;

use App\Constants\PermissionSlug;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DefaultRolesAndPermissionsSeeder extends Seeder
{

    public function run(): void
    {
        $baseRolesPermission = [
            [
                'name' => 'Admin',
                'permissions' => [
                    PermissionSlug::USERS_VIEW_ANY,
                    PermissionSlug::USERS_VIEW,
                    PermissionSlug::USERS_SHOW,
                    PermissionSlug::USERS_CREATE,
                    PermissionSlug::USERS_UPDATE,
                    PermissionSlug::USERS_DELETE,

                    PermissionSlug::SITES_VIEW_ANY,
                    PermissionSlug::SITES_VIEW,
                    PermissionSlug::SITES_SHOW,
                    PermissionSlug::SITES_CREATE,
                    PermissionSlug::SITES_UPDATE,
                    PermissionSlug::SITES_DELETE,

                    PermissionSlug::ROLES_VIEW_ANY,
                    PermissionSlug::ROLES_VIEW,
                    PermissionSlug::ROLES_SHOW,
                    PermissionSlug::ROLES_CREATE,
                    PermissionSlug::ROLES_UPDATE,
                    PermissionSlug::ROLES_DELETE,
                ],
            ],
            [
                'name' => 'Customer',
                'permissions' => [
                    PermissionSlug::SITES_VIEW_ANY,
                    PermissionSlug::SITES_VIEW,
                    PermissionSlug::SITES_SHOW,
                ],
            ],
            [
                'name' => 'Guests',
                'permissions' => [
                ],
            ],
        ];

        foreach ($baseRolesPermission as $role){
            $rol = Role::query()->updateOrcreate([
                'name' => $role['name'],
            ]);

            $rol->syncPermissions($role['permissions']);
        }

        User::query()->find( id: 1 )
            ->assignRole('Admin');

        User::query()->find( id: 2 )
            ->assignRole('Customer');
    }
}
