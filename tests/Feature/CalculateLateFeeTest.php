<?php

namespace Tests\Feature;

use App\Jobs\CalculateLateFee;
use App\Models\Invoice;
use App\Models\Site;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CalculateLateFeeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function it_calculates_late_fee_for_overdue_invoices(): void
    {
        DB::table('invoices')->truncate();
        $site = Site::first();

        $invoice = Invoice::factory()->create([
            'due_date' => now()->subDays(5),
            'amount' => 1000,
            'total_amount' => 1000,
            'site_id' => $site->id,
            'status' => 'overdue',
        ]);

        $delayDays = now()->diffInDays($invoice->payment_date);

        $this->assertNotNull($invoice, 'La factura no se ha creado correctamente.');
        $this->assertNotNull($invoice->id, 'La factura no tiene un ID válido.');

        (new CalculateLateFee())->handle();

        $invoice->refresh();

        $expectedLateFee = 0.02 * $invoice->amount * $delayDays;
        $this->assertEquals($expectedLateFee, $invoice->late_fee);
        $this->assertEquals(1000 + $expectedLateFee, $invoice->total_amount);
        $this->assertEquals($delayDays, $invoice->delay_days);
    }

    /** @test */
    public function it_does_not_calculate_late_fee_for_invoices_not_yet_due(): void
    {
        $site = Site::first();
        $this->assertNotNull($site, 'No hay sitios disponibles en la base de datos.');

        $invoice = Invoice::factory()->create([
            'due_date' => now()->addDays(2),
            'amount' => 1000,
            'site_id' => $site->id,
        ]);

        (new CalculateLateFee())->handle();

        $invoice->refresh();

        $this->assertNull($invoice->late_fee);
        $this->assertNull($invoice->delay_days);
    }
}
