<?php

namespace App\Http\Controllers;

use App\Jobs\SendInvoiceAlerts;
use App\Models\Invoice;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        $invoicesToAlert = Invoice::where('due_date', '<=', $today)
            ->where('status', '!=', 'paid')
            ->get();

        foreach ($invoicesToAlert as $invoice) {
            if ($invoice instanceof Invoice) {
                $user = $invoice->user;
                SendInvoiceAlerts::dispatch($invoice, $user, 'overdue');
            } else {
                Log::error('El objeto no es una instancia de Invoice.', ['invoice' => $invoice]);
            }
        }
        $invoicesDueSoon = Invoice::where('due_date', '<=', $threeDaysFromNow)
            ->where('due_date', '>', $today)
            ->where('status', '!=', 'paid')
            ->get();

        foreach ($invoicesDueSoon as $invoice) {
            if ($invoice instanceof Invoice) {
                $user = $invoice->user;
                SendInvoiceAlerts::dispatch($invoice, $user, 'due_soon');
            } else {
                Log::error('El objeto no es una instancia de Invoice.', ['invoice' => $invoice]);
            }
        }

        return response()->json(['message' => 'Alerts sent successfully.']);
    }

}
