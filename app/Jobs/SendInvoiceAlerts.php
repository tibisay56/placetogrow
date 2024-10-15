<?php

namespace App\Jobs;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendInvoiceAlerts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $upcomingInvoices = Invoice::where('status', 'pending')
            ->where('due_date', '<=', Carbon::now()->addDays(3))
            ->where('due_date', '>', Carbon::now())
            ->get();

        foreach ($upcomingInvoices as $invoice) {
            Log::info("Factura próxima a vencer: {$invoice->reference}");
            // Mail::to($invoice->customer_email)->send(new InvoiceDueSoon($invoice));
        }

        $overdueInvoices = Invoice::where('status', '!=', 'paid')
            ->where('due_date', '<', Carbon::now())
            ->get();

        foreach ($overdueInvoices as $invoice) {
            Log::info("Factura vencida: {$invoice->reference}");
            // Mail::to($invoice->customer_email)->send(new InvoiceOverdue($invoice));
        }
    }
}
