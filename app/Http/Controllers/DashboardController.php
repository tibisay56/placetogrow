<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(): \Inertia\Response
    {
        $user = auth()->user();

        $totalPaidInvoices = Invoice::where('status', 'paid')->count();
        $totalPendingInvoices = Invoice::where('status', 'pending')->count();
        $totalOverdueInvoices = Invoice::where('status', 'overdue')->count();

        $totalPaidAmount = Invoice::where('status', 'paid')->sum('amount');
        $totalPendingAmount = Invoice::where('status', 'pending')->sum('amount');
        $totalOverdueAmount = Invoice::where('status', 'overdue')->sum('amount');

        return Inertia::render('Dashboard', [
            'user' => $user,
            'roles' => $user ? $user->roles : [],
            'totalpaidInvoices' => $totalPaidInvoices,
            'totalpendingInvoices' => $totalPendingInvoices,
            'totaloverdueInvoices' => $totalOverdueInvoices,

            'totalPaidAmount' => $totalPaidAmount,
            'totalPendingAmount' => $totalPendingAmount,
            'totalOverdueAmount' => $totalOverdueAmount,
        ]);
    }
}
