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
                'permissions' => array_merge([
                    PermissionSlug::USERS_VIEW_ANY,
                    PermissionSlug::USERS_VIEW,
                    PermissionSlug::USERS_CREATE,
                    PermissionSlug::USERS_UPDATE,
                    PermissionSlug::USERS_DELETE,

                    PermissionSlug::SITES_VIEW_ANY,
                    PermissionSlug::SITES_VIEW,
                    PermissionSlug::SITES_CREATE,
                    PermissionSlug::SITES_UPDATE,
                    PermissionSlug::SITES_DELETE,

                    PermissionSlug::ROLES_VIEW_ANY,
                    PermissionSlug::ROLES_VIEW,
                    PermissionSlug::ROLES_CREATE,
                    PermissionSlug::ROLES_UPDATE,
                    PermissionSlug::ROLES_DELETE,

                    PermissionSlug::PAYMENTS_VIEW_ANY,
                    PermissionSlug::PAYMENTS_VIEW,
                    PermissionSlug::PAYMENTS_CREATE,
                    PermissionSlug::PAYMENTS_UPDATE,
                    PermissionSlug::PAYMENTS_DELETE,

                    PermissionSlug::VIEW_TRANSACTIONS,
                ]),
            ],
            [
                'name' => 'Customer',
                'permissions' => [
                    PermissionSlug::SITES_VIEW_ANY,
                    PermissionSlug::SITES_VIEW,

                    PermissionSlug::VIEW_TRANSACTIONS,
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
                'guard_name' => 'web',
            ]);

            $rol->syncPermissions($role['permissions']);
        }

        $adminUser = User::where('email', 'admin@admin.com')->first();
        if ($adminUser) {
            $adminUser->syncRoles('Admin');
        }

        $customerUser = User::where('email', 'customer@example.com')->first();
        if ($customerUser) {
            $customerUser->syncRoles('Customer');
        }
    }
}
