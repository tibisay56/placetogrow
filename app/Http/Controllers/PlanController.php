<?php

namespace App\Http\Controllers;

use App\Constants\BillingFrequency;
use App\Constants\CurrencyType;
use App\Constants\PermissionSlug;
use App\Constants\PlanTypeName;
use App\Http\Requests\Plan\StoreRequest;
use App\Http\Requests\Plan\UpdateRequest;
use App\Models\Plan;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PlanController extends Controller
{
    public function index(): Response
    {

        $user = auth()->user();
        if ($user->hasRole('Admin')) {
            $plans = Plan::with('planType', 'site')->get();
        } else {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Plan/Index', [
            'plans' => $plans,
        ]);
    }

    public function create(): Response
    {
        if (! Auth::user()->can(PermissionSlug::PLANS_CREATE)) {
            abort(403);
        }

        $sites = Site::where('type_id', 3)->get();

        $currencies = CurrencyType::toArray();
        $planTypes = PlanTypeName::toArray();
        $billingFrequencies = BillingFrequency::toArray();

        return Inertia::render('Plan/Create', [
            'sites' => $sites,
            'currencies' => $currencies,
            'billingFrequencies' => $billingFrequencies,
            'planTypes' => $planTypes,
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        if (! Auth::user()->can(PermissionSlug::PLANS_CREATE)) {
            abort(403);
        }

        $validated = $request->validated();

        Plan::create($validated);

        return redirect()->route('plan.index')->with('message', 'Plan plan created successfully');
    }

    public function show(Plan $plan): Response
    {
        if (! Auth::user()->can(PermissionSlug::PLANS_CREATE)) {
            abort(403);
        }

        $sites = Site::where('type_id', 3)->get();
        $currencies = CurrencyType::toArray();
        $billingFrequencies = BillingFrequency::toArray();
        $planTypes = PlanTypeName::toArray();

        return Inertia::render('Plan/Show', [
            'sites' => $sites,
            'plan' => $plan,
            'currencies' => $currencies,
            'billingFrequencies' => $billingFrequencies,
            'planTypes' => $planTypes,
        ]);
    }

    public function edit(Plan $plan): Response
    {

        if (! Auth::user()->can(PermissionSlug::PLANS_UPDATE)) {
            abort(403);
        }

        $sites = Site::where('type_id', 3)->get();
        $currencies = CurrencyType::toArray();
        $billingFrequencies = BillingFrequency::toArray();
        $planTypes = PlanTypeName::toArray();

        return Inertia::render('Plan/Edit', [
            'sites' => $sites,
            'plan' => $plan,
            'currencies' => $currencies,
            'billingFrequencies' => $billingFrequencies,
            'planTypes' => $planTypes,
        ]);
    }

    public function update(UpdateRequest $request, Plan $plan): RedirectResponse
    {
        if (! Auth::user()->can(PermissionSlug::PLANS_UPDATE)) {
            abort(403);
        }
        $validated = $request->validated();

        $plan->update($validated);

        return redirect()->route('plan.index')->with('message', 'Plan updated successfully');
    }

    public function destroy(Plan $plan): RedirectResponse
    {
        if (! Auth::user()->can(PermissionSlug::PLANS_DELETE)) {
            abort(403);
        }

        $plan->delete();

        return redirect()->route('plan.index')->with('message', 'Plan deleted successfully');
    }
}
