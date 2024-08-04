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

        return Inertia::render('Setting/Index', [
            'settings' => $settings,
        ]);
    }

    public function create(): Response
    {
        $sites = Site::all();

        return Inertia::render('Setting/Create', [
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

        return redirect()->route('settings.index')->with('success', 'Payment settings created successfully.');
    }

    public function edit(PaymentSetting $paymentSetting): Response
    {
        $sites = Site::all();

        return Inertia::render('Transaction/PaymentSettings/Edit', [
            'paymentSetting' => $paymentSetting,
            'sites' => $sites,
        ]);
    }

    public function update(Request $request, PaymentSetting $paymentSetting): RedirectResponse
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'required_fields' => 'nullable|array',
        ]);

        $setting = PaymentSetting::findOrFail($id);
        $setting->update($validated);;

        return redirect()->route('settings.index')->with('success', 'Payment settings updated successfully.');
    }

    public function destroy(PaymentSetting $paymentSetting): RedirectResponse
    {
        $paymentSetting->delete();

        return redirect()->route('setting.index')->with('success', 'Payment settings deleted successfully.');
    }
}
