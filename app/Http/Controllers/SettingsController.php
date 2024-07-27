<?php

namespace App\Http\Controllers;

use App\Models\PaymentSetting;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function index(): Response
    {
        $settings = PaymentSetting::with('site')->get();
        return Inertia::render('Admin/PaymentSettings/Index', [
            'settings' => $settings,
        ]);
    }

    public function create(): Response
    {
        $sites = Site::all();
        return Inertia::render('Admin/PaymentSettings/Create', [
            'sites' => $sites,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'required_fields' => 'nullable|array',
            'currency' => 'required|string',
            'payment_expiration_time' => 'required|integer|min:1',
        ]);

        PaymentSetting::create($validated);

        return redirect()->route('admin.payment-settings.index')->with('success', 'Payment settings created successfully.');
    }

    public function edit(PaymentSetting $paymentSetting): Response
    {
        $sites = Site::all();
        return Inertia::render('Admin/PaymentSettings/Edit', [
            'paymentSetting' => $paymentSetting,
            'sites' => $sites,
        ]);
    }

    public function update(Request $request, PaymentSetting $paymentSetting): RedirectResponse
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'required_fields' => 'nullable|array',
            'currency' => 'required|string',
            'payment_expiration_time' => 'required|integer|min:1',
        ]);

        $paymentSetting->update($validated);

        return redirect()->route('admin.payment-settings.index')->with('success', 'Payment settings updated successfully.');
    }

    public function destroy(PaymentSetting $paymentSetting): RedirectResponse
    {
        $paymentSetting->delete();
        return redirect()->route('admin.payment-settings.index')->with('success', 'Payment settings deleted successfully.');
    }
}
