<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\RoleFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            DefaultRolesAndPermissionsSeeder::class,
            UserSeeder::class,
            TypeSeeder::class,
            SitesSeeder::class,
        ]);
    }
}
