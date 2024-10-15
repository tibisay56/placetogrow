<?php

namespace App\Jobs;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateLateFee implements ShouldQueue
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
        $invoices = Invoice::where('status', 'overdue')
            ->whereDate('due_date', '<', Carbon::now())
            ->get();

        foreach ($invoices as $invoice) {

            $delayDays = abs(now()->diffInDays($invoice->due_date));
            $lateFeeRate = 0.02;

            $lateFee = $delayDays > 0 ? $invoice->amount * $lateFeeRate * $delayDays : 0;

            $invoice->late_fee = $lateFee;
            $invoice->total_amount = $invoice->amount + $lateFee;
            $invoice->delay_days = $delayDays;
            $invoice->save();
        }
    }
}
