<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Seeder;

class SitesSeeder extends Seeder
{
    public function run(): void
    {

        $sites = Site::factory()->count(10)->create();

        $users = User::inRandomOrder()->take($sites->count())->get();

        foreach ($sites as $index => $site) {

            $site->user_id = $users[$index]->id;
            $site->save();

            Payment::factory()->count(2)->create([
                'site_id' => $site->id,
                'user_id' => $users[$index]->id,
            ]);
        }
    }
}
