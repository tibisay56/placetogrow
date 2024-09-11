<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Site;
use Inertia\Inertia;
use Inertia\Response;

class InvoiceController extends Controller
{
    public function index(Site $site): Response
    {
        $invoices = Invoice::all();

        return Inertia::render('Invoice/Index', [
            'site' => $site,
            'invoices' => $invoices,
        ]);
    }
}
