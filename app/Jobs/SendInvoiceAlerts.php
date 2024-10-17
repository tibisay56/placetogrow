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

    protected $invoice;

    protected $user;

    protected $alertType;

    /**
     * Create a new job instance.
     */
    public function __construct(Invoice $invoice, $user, $alertType)
    {
        $this->invoice = $invoice;
        $this->user = $user;
        $this->alertType = $alertType;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $invoice = $this->invoice;
        $user = $invoice->user;

        Log::info("Enviando correo para la factura: {$invoice->reference} al usuario: {$this->user->email}");

        if ($this->alertType === 'due_soon') {
            Mail::to($user->email)->send(new InvoiceDueSoon($user, $invoice->reference, $invoice->amount));
        } elseif ($this->alertType === 'overdue') {
            Mail::to($user->email)->send(new InvoiceOverdue($user, $invoice->reference, $invoice->amount));
        }
    }
}
