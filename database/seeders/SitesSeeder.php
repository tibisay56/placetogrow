<?php

namespace Database\Seeders;

use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Seeder;

class SitesSeeder extends Seeder
{
    public function run(): void
    {

        $sites = Site::factory()->count(25)->create();

        Site::factory()->create([
            'name' => 'Test Site',
        ]);

        $users = User::all();

        foreach ($sites as $site) {
            $user = $users->random();

            $site->user_id = $user->id;
            $site->save();
        }
    }
}
