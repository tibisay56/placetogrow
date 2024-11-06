<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    public function index(): Response
    {
        $settings = Setting::all();

        return Inertia::render('Setting/Index', [
            'retryInterval' => $setting->retry_interval ?? 1,
            'maxRetries' => $setting->max_retries ?? 3,
            'settings' => $settings,
        ]);
    }

    public function edit(Request $request): Response
    {
        $setting = Setting::first();

        return Inertia::render('Setting/Edit', [
            'retryInterval' => $setting->retry_interval ?? 1,
            'maxRetries' => $setting->max_retries ?? 3,
            'settings' => $setting,
        ]);
    }

    public function update(Request $request, Setting $setting): RedirectResponse
    {
        $setting->update($request->all());
        $setting->update($request->all());

        $request->validate([
            'retry_interval' => 'required|integer|min:1',
            'max_retries' => 'required|integer|min:1',
        ]);

        $setting->update([
            'retry_interval' => $request->input('retry_interval'),
            'max_retries' => $request->input('max_retries'),
        ]);

        return redirect()->route('setting.index')->with('success', 'Parameters updated successfully.');
    }
}
