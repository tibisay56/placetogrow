<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class InvoiceController extends Controller
{
    public function index(Site $site): Response
    {

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
}
