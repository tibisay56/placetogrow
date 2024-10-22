<?php

namespace App\Http\Controllers;

use App\Jobs\SendInvoiceAlerts;
use App\Models\Invoice;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class InvoiceController extends Controller
{
    public function index(Site $site): Response
    {
        $this->checkInvoices();

        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            $invoices = Invoice::with(['site'])->get();
        } else {
            $invoices = Invoice::with(['site'])
                ->where('user_id', $user->id)
                ->get();
        }

        return Inertia::render('Invoice/Index', [
            'site' => $site,
            'invoices' => $invoices,
        ]);
    }

    public function show($id): Response
    {
        $invoice = Invoice::findOrFail($id);

        return Inertia::render('Invoice/Show', [
            'invoice' => $invoice,
        ]);
    }

    public function checkInvoices(): \Illuminate\Http\JsonResponse
    {
        $today = Carbon::today();
        $threeDaysFromNow = $today->copy()->addDays(3);
        Log::info('Starting the overdue invoice check.');

        $invoicesToAlert = Invoice::where('due_date', '<=', $today)
            ->where('status', '!=', 'paid')
            ->get();

        foreach ($invoicesToAlert as $invoice) {
            if ($invoice instanceof Invoice) {
                $user = $invoice->user;
                Log::info("Dispatching overdue invoice alert for user {$user->email}.");
                SendInvoiceAlerts::dispatch($invoice, $user, 'overdue');
            } else {
                Log::error('The object is not an instance of Invoice.', ['invoice' => $invoice]);
            }
        }

        Log::info('Starting the upcoming invoice check.');

        $invoicesDueSoon = Invoice::where('due_date', '<=', $threeDaysFromNow)
            ->where('due_date', '>', $today)
            ->where('status', '!=', 'paid')
            ->get();

        foreach ($invoicesDueSoon as $invoice) {
            if ($invoice instanceof Invoice) {
                $user = $invoice->user;
                Log::info("Dispatching upcoming invoice alert for user {$user->email}.");
                SendInvoiceAlerts::dispatch($invoice, $user, 'due_soon');
            } else {
                Log::error('The object is not an instance of Invoice.', ['invoice' => $invoice]);
            }
        }
        Log::info('Alert process completed.');

        return response()->json(['message' => 'Alerts sent successfully.']);
    }
}
