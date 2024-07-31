<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        $adminEmail = 'admin@admin.com';
        $customerEmail = 'customer@example.com';

        if (!User::where('email', $adminEmail)->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
            ])->assignRole('Admin');
        }

        if (!User::where('email', $customerEmail)->exists()) {
            User::create([
                'name' => 'Customer',
                'email' => 'customer@example.com',
                'password' => bcrypt('password'),
            ])->assignRole('Customer');
        }

        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('Customer');
        });

    }
}
