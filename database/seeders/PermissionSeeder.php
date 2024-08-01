<?php

namespace Database\Seeders;

use App\Constants\PermissionSlug;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = array_merge(PermissionSlug::toArray(), [
            'manage payments',
            'view transactions',
        ]);

        foreach ($permissions as $permission) {
            Permission::query()->updateOrcreate([
                'name' => $permission,
                'guard_name' => 'web',
            ], [
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
