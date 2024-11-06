<?php

namespace App\Jobs;

use App\Mail\InvoiceDueSoon;
use App\Mail\InvoiceOverdue;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        $invoicesToAlert = Invoice::where('due_date', '<=', now())
            ->where('status', '!=', 'paid')
            ->get();

        foreach ($invoicesToAlert as $invoice) {
            $user = $invoice->user;
            $alertType = 'overdue';

            Log::info("Sending email for the invoice: {$invoice->reference} to the user: {$user->email}");

            if ($alertType === 'due_soon') {
                Mail::to($user->email)->send(new InvoiceDueSoon($user, $invoice->reference, $invoice->amount));
            } elseif ($alertType === 'overdue') {
                Mail::to($user->email)->send(new InvoiceOverdue($user, $invoice->reference, $invoice->amount));
            }
            $this->invoice->update(['email_sent' => true]);
            $this->delay(5);
        }

    }

    public function delay(int $seconds)
    {
        $this->release($seconds);
    }
}
