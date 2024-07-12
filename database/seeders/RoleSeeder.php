<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleCustomer = Role::create(['name' => 'Customer']);
        $roleGuest = Role::create(['name' => 'Guest']);

        Permission::create(['name' => 'dashboard'])->syncRoles([$roleAdmin, $roleCustomer, $roleGuest]);

        Permission::create(['name' => 'dashboard.sites.index'])->syncRoles([$roleAdmin, $roleCustomer]);
        Permission::create(['name' => 'dashboard.sites.show'])->syncRoles([$roleAdmin, $roleCustomer]);
        Permission::create(['name' => 'dashboard.sites.create'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'dashboard.sites.edit'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'dashboard.sites.destroy'])->syncRoles([$roleAdmin]);


        Permission::create(['name' => 'dashboard.users.index'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'dashboard.users.show'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'dashboard.users.create'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'dashboard.users.edit'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'dashboard.users.destroy'])->syncRoles([$roleAdmin]);

        Permission::create(['name' => 'dashboard.roles.index'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'dashboard.roles.show'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'dashboard.roles.create'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'dashboard.roles.edit'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'dashboard.roles.destroy'])->syncRoles([$roleAdmin]);
    }
}
