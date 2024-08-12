<?php

namespace Database\Seeders;

use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Seeder;

class SitesSeeder extends Seeder
{
    public function run(): void
    {

        $sites = Site::factory()->count(10)->create();

        Site::factory()->create([
            'name' => 'Test Site',
        ]);

        foreach ($sites as $site) {
            $user = User::inRandomOrder()->first();

            $site->user_id = $user->id;
            $site->save();
        }
    }
}
