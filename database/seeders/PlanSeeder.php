<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Site;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscriptionSites = Site::whereHas('type', function ($query) {
            $query->where('name', 'subscriptions');
        })->get();

        foreach ($subscriptionSites as $site) {

            Plan::factory()->create([
                'site_id' => $site->id,
                'name' => 'Basic',
                'amount' => 1000,
            ]);

            Plan::factory()->create([
                'site_id' => $site->id,
                'name' => 'Medium',
                'amount' => 5000,
            ]);

            Plan::factory()->create([
                'site_id' => $site->id,
                'name' => 'Premium',
                'amount' => 10000,
            ]);
        }
    }
}
