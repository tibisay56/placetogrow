<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Site;
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
        $siteIds = Site::factory()->count(14)->create()->pluck('id');

        foreach ($siteIds as $siteId) {
            Payment::factory()->count(1)->create([
                'site_id' => $siteId,
            ]);
        }
    }
}
