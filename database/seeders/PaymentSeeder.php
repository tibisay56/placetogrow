<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Seed the application's database with payments.
     *
     * @return void
     */
    public function run()
    {
        $sites = Site::factory()->count(10)->create();
        $users = User::all();

        foreach ($sites as $site) {
            $user = $users->random();

            Payment::factory()->create([
                'site_id' => $site->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
