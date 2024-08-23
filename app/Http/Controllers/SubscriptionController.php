<?php

namespace App\Http\Controllers;

use App\Constants\BillingFrecuency;
use App\Constants\CurrencyType;
use App\Http\Requests\Subscription\StoreRequest;
use App\Http\Requests\Subscription\UpdateRequest;
use App\Models\Site;
use App\Models\SubscriptionPlan;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SubscriptionController extends Controller
{
    public function index(): Response
    {

        $subscriptionPlans = SubscriptionPlan::with('site')->get();

        return Inertia::render('SubscriptionPlan/Index', [
            'subscriptions' => $subscriptionPlans,
        ]);
    }

    public function create(): Response
    {
        $sites = Site::where('type_id', 3)->get();

        $currencies = CurrencyType::toArray();
        $billingFrequencies = BillingFrecuency::toArray();

        return Inertia::render('SubscriptionPlan/Create', [
            'sites' => $sites,
            'currencies' => $currencies,
            'billingFrequencies' => $billingFrequencies,
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        SubscriptionPlan::create($validated);

        return redirect()->route('subscription.index')->with('message', 'Subscription plan created successfully');
    }

    public function show(SubscriptionPlan $subscription): Response
    {
        $currencies = CurrencyType::toArray();
        $billingFrequencies = BillingFrecuency::toArray();

        return Inertia::render('SubscriptionPlan/Show', [
            'subscription' => $subscription,
            'currencies' => $currencies,
            'billingFrequencies' => $billingFrequencies,
        ]);
    }

    public function edit(SubscriptionPlan $subscription): Response
    {
        $sites = Site::where('type_id', 3)->get();
        $currencies = CurrencyType::toArray();
        $billingFrequencies = BillingFrecuency::toArray();

        return Inertia::render('SubscriptionPlan/Edit', [
            'sites' => $sites,
            'subscription' => $subscription,
            'currencies' => $currencies,
            'billingFrequencies' => $billingFrequencies,
        ]);
    }

    public function update(UpdateRequest $request, SubscriptionPlan $subscription): RedirectResponse
    {

        $validated = $request->validated();

        $subscription->update($validated);

        return redirect()->route('subscription.index')->with('message', 'Subscription plan updated successfully');
    }

    public function destroy(SubscriptionPlan $subscription): RedirectResponse
    {
        $subscription->delete();

        return redirect()->route('subscription.index')->with('message', 'Subscription plan deleted successfully');
    }
}
