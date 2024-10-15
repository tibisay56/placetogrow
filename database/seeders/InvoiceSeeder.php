<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Site;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sites = Site::all();

        foreach ($sites as $site) {
            Invoice::factory()->count(5)->create([
                'site_id' => $site->id,
            ]);
        }

        $invoicesCreated = Invoice::count();

        if ($invoicesCreated < 100) {
            $remainingInvoices = 100 - $invoicesCreated;
            Invoice::factory()->count($remainingInvoices)->create();
        }
    }
}
