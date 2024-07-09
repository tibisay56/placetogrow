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

        Permission::create(['name' => 'dashboard.sites.index']);
        Permission::create(['name' => 'dashboard.sites.create']);
        Permission::create(['name' => 'dashboard.sites.edit']);
        Permission::create(['name' => 'dashboard.sites.destroy']);

        Permission::create(['name' => 'user.users.index']);
        Permission::create(['name' => 'user.users.create']);
        Permission::create(['name' => 'user.users.edit']);
        Permission::create(['name' => 'user.users.destroy']);
    }
}
