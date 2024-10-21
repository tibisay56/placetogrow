<?php

namespace App\Http\Controllers;

use App\Http\Requests\Metrics\StoreMetricsRequest;
use App\Models\InvoiceMetric;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class MetricsController extends Controller
{
    public function index(): \Inertia\Response
    {
        $metrics = InvoiceMetric::with('site')->get()->map(function ($metric) {
            return [
                'totalInvoices' => $metric->metrics['total_invoices'] ?? 0,
                'totalAmount' => $metric->metrics['total_amount'] ?? 0,
                'totalPaid' => $metric->metrics['total_paid'] ?? 0,
                'totalOverdue' => $metric->metrics['total_overdue'] ?? 0,
                'totalPending' => $metric->metrics['total_pending'] ?? 0,
                'totalPaidAmount' => $metric->metrics['total_paid_amount'] ?? 0,
                'totalOverdueAmount' => $metric->metrics['total_overdue_amount'] ?? 0,
                'totalPendingAmount' => $metric->metrics['total_pending_amount'] ?? 0,
                'pendingMinusOverdueAmount' => $metric->metrics['pending_minus_overdue_amount'] ?? 0,
                'paidMinusPendingAmount' => $metric->metrics['paid_minus_pending_amount'] ?? 0,
                'percentagePaid' => $metric->metrics['percentage_paid'] ?? 0,
                'percentagePending' => $metric->metrics['percentage_pending'] ?? 0,
                'percentageOverdue' => $metric->metrics['percentage_overdue'] ?? 0,
                'site' => $metric->site,
            ];
        });

        $sites = Site::all();
        $siteId = request()->input('siteId');

        return Inertia::render('Metrics/Index', [
            'metrics' => $metrics,
            'sites' => $sites,
            'siteId' => $siteId,
        ]);
    }

    public function store(StoreMetricsRequest $request): RedirectResponse
    {
        $request->validate([
            'metrics' => 'required|json',
            'site_id' => 'required|exists:sites,id',
        ]);

        InvoiceMetric::create([
            'metrics' => $request->input('metrics'),
            'site_id' => $request->input('site_id'),
        ]);

        return redirect()->route('metrics.index')->with('success', 'Metric saved successfully.');
    }
}
