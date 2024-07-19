<?php

namespace Database\Seeders;

use App\Models\Site;
use App\Models\SiteUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class SitesSeeder extends Seeder
{

    public function run(): void
    {
        $sites = Site::factory()->count(10)->create();

        foreach ($sites as $site) {
            $users = User::inRandomOrder()->limit(3)->get();

            foreach ($users as $user) {
                SiteUser::create([
                    'site_id' => $site->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
