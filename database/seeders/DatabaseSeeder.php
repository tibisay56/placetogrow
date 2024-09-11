<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            DefaultRolesAndPermissionsSeeder::class,
            UserSeeder::class,
            TypeSeeder::class,
            SitesSeeder::class,
            PlanTypeSeeder::class,
            PlanSeeder::class,
            SubscriptionSeeder::class,
            ImportSeeder::class,
            InvoiceSeeder::class,
        ]);
    }
}
