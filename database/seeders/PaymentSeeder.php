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
        $siteId = Site::first()->id;
        Payment::factory()->count(10)->create([
            'site_id' => $siteId,
        ]);
    }
}
