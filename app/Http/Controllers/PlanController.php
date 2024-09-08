<?php

namespace App\Http\Controllers;

use App\Constants\BillingFrecuency;
use App\Constants\CurrencyType;
use App\Constants\PlanTypeName;
use App\Http\Requests\Subscription\StoreRequest;
use App\Http\Requests\Subscription\UpdateRequest;
use App\Models\Site;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SubscriptionController extends Controller
{
    public function index(): Response
    {

        $subscriptionPlans = Subscription::with('planType','site')->get();

        return Inertia::render('Subscription/Index', [
            'subscriptions' => $subscriptionPlans,
        ]);
    }

    public function create(): Response
    {
        $sites = Site::where('type_id', 3)->get();

        $currencies = CurrencyType::toArray();
        $planTypes = PlanTypeName::toArray();
        $billingFrequencies = BillingFrecuency::toArray();

        return Inertia::render('Subscription/Create', [
            'sites' => $sites,
            'currencies' => $currencies,
            'billingFrequencies' => $billingFrequencies,
            'planTypes' => $planTypes,
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Subscription::create($validated);

        return redirect()->route('subscription.index')->with('message', 'Subscription plan created successfully');
    }

    public function show(Subscription $subscription): Response
    {
        $sites = Site::where('type_id', 3)->get();
        $currencies = CurrencyType::toArray();
        $billingFrequencies = BillingFrecuency::toArray();
        $planTypes = PlanTypeName::toArray();

        return Inertia::render('Subscription/Show', [
            'sites' => $sites,
            'subscription' => $subscription,
            'currencies' => $currencies,
            'billingFrequencies' => $billingFrequencies,
            'planTypes' => $planTypes,
        ]);
    }

    public function edit(Subscription $subscription): Response
    {
        $sites = Site::where('type_id', 3)->get();
        $currencies = CurrencyType::toArray();
        $billingFrequencies = BillingFrecuency::toArray();
        $planTypes = PlanTypeName::toArray();

        return Inertia::render('Subscription/Edit', [
            'sites' => $sites,
            'subscription' => $subscription,
            'currencies' => $currencies,
            'billingFrequencies' => $billingFrequencies,
            'planTypes' => $planTypes,
        ]);
    }

    public function update(UpdateRequest $request, Subscription $subscription): RedirectResponse
    {

        $validated = $request->validated();

        $subscription->update($validated);

        return redirect()->route('subscription.index')->with('message', 'Subscription plan updated successfully');
    }

    public function destroy(Subscription $subscription): RedirectResponse
    {
        $subscription->delete();

        return redirect()->route('subscription.index')->with('message', 'Subscription plan deleted successfully');
    }
}
