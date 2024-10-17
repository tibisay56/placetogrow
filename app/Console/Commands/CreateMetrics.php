<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\InvoiceMetric;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateMetrics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-metrics {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoices for the given date';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $date = $this->argument('date');

        $invoicesBySite = Invoice::whereDate('created_at', $date)
            ->select(
                'site_id',
                DB::raw('count(*) as total_invoices'),
                DB::raw('sum(case when status = "paid" then 1 else 0 end) as total_paid'),
                DB::raw('sum(case when status = "overdue" then 1 else 0 end) as total_overdue'),
                DB::raw('sum(case when status = "pending" then 1 else 0 end) as total_pending'),
                DB::raw('sum(case when status in ("paid", "pending", "overdue") then amount else 0 end) as total_amount'),
                DB::raw('sum(case when status = "paid" then amount else 0 end) as total_paid_amount'),
                DB::raw('sum(case when status = "overdue" then amount else 0 end) as total_overdue_amount'),
                DB::raw('sum(case when status = "pending" then amount else 0 end) as total_pending_amount'),
                DB::raw('sum(case when status = "paid" then amount else 0 end) - sum(case when status = "pending" then amount else 0 end) as paid_minus_pending_amount'),
                DB::raw('sum(case when status = "pending" then amount else 0 end) - sum(case when status = "overdue" then amount else 0 end) as pending_minus_overdue_amount'),
                DB::raw('sum(case when status = "paid" then amount else 0 end) / nullif(sum(amount), 0) * 100 as percentage_paid'),
                DB::raw('sum(case when status = "pending" then amount else 0 end) / nullif(sum(amount), 0) * 100 as percentage_pending'),
                DB::raw('sum(case when status = "overdue" then amount else 0 end) / nullif(sum(amount), 0) * 100 as percentage_overdue'),
            )
            ->groupBy('site_id')
            ->get();

        foreach ($invoicesBySite as $invoice) {
            $siteId = $invoice->site_id;
            $totalInvoices = $invoice->total_invoices;
            $totalAmount = $invoice->total_amount;

            $totalPaid = $invoice->total_paid;
            $totalOverdue = $invoice->total_overdue;
            $totalPending = $invoice->total_pending;

            $totalPaidAmount = $invoice->total_paid_amount;
            $totalOverdueAmount = $invoice->total_overdue_amount;
            $totalPendingAmount = $invoice->total_pending_amount;

            $paidMinusPendingAmount = $invoice->paid_minus_pending_amount;
            $pendingMinusOverdueAmount = $invoice->pending_minus_overdue_amount;

            $percentagePaid = $invoice->percentage_paid;
            $percentagePending = $invoice->percentage_pending;
            $percentageOverdue = $invoice->percentage_overdue;

            InvoiceMetric::updateOrCreate(
                ['site_id' => $siteId, 'date' => $date],
                [
                    'metrics' => [
                        'total_invoices' => $totalInvoices,
                        'total_paid' => $totalPaid,
                        'total_overdue' => $totalOverdue,
                        'total_pending' => $totalPending,
                        'total_paid_amount' => $totalPaidAmount,
                        'total_overdue_amount' => $totalOverdueAmount,
                        'total_pending_amount' => $totalPendingAmount,
                        'total_amount' => $totalAmount,
                        'paid_minus_pending_amount' => $paidMinusPendingAmount,
                        'pending_minus_overdue_amount' => $pendingMinusOverdueAmount,
                        'percentage_paid' => $percentagePaid,
                        'percentage_pending' => $percentagePending,
                        'percentage_overdue' => $percentageOverdue,
                    ],
                    'date' => $date,
                ]
            );
            $this->info("Creating metrics for site ID: {$siteId} on date: {$date}");
        }
    }
}
