<?php

namespace App\Http\Controllers;

use App\Constants\BillingFrequency;
use App\Constants\CurrencyType;
use App\Constants\DocumentTypes;
use App\Constants\SubscriptionStatus;
use App\Http\Requests\Subscription\StoreRequest;
use App\Mail\ConfirmationMail;
use App\Models\Plan;
use App\Models\Site;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class SubscriptionController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $subscriptions = Subscription::with('plan')->get();
        } else {
            $subscriptions = Subscription::with('plan')
                ->where('user_id', $user->id)
                ->get();
        }

        return Inertia::render('Subscription/Index', [
            'subscriptions' => $subscriptions,
        ]);
    }

    public function show($id): Response
    {
        $subscription = Subscription::with('plan')->findOrFail($id);
        $sites = Site::where('type_id', 3)->get();
        $currencies = CurrencyType::toArray();
        $billingFrequencies = BillingFrequency::toArray();

        return Inertia::render('Subscription/Show', [
            'subscription' => $subscription,
            'sites' => $sites,
            'currencies' => $currencies,
            'billingFrequencies' => $billingFrequencies,
        ]);
    }

    public function create($siteId): Response
    {

        $site = Site::findOrFail($siteId);
        $plans = $site->plans()->with('planType')->get();

        return Inertia::render('Subscription/Create', [
            'site' => $site,
            'plans' => $plans,
            'documentTypes' => DocumentTypes::toArray(),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'required_fields' => $site->required_fields,
        ]);
    }

    public function store(StoreRequest $request, Site $site): \Symfony\Component\HttpFoundation\Response
    {
        $validatedData = $request->validated();

        $planId = $validatedData['plan_id'];
        $plan = Plan::find($planId);

        $description = 'Plan '.$plan->type.' COP $'.$plan->price;
        $reference = 'PAYMENT_0001'.'_'.Str::random(4);
        $email = $validatedData['email'];
        $name = $validatedData['name'];

        $user = User::query()->where('email', $email)->first();
        if (! $user) {
            $user = User::query()->create([
                'email' => $email,
                'name' => $name,
                'password' => Hash::make('password'),
            ]);
        }
        $subscription = Subscription::query()->create([
            'reference' => $reference,
            'site_id' => $site->getKey(),
            'user_id' => $user->getKey(),
            'email' => $validatedData['email'],
            'plan_id' => $validatedData['plan_id'],
            'name' => $validatedData['name'],
            'document_number' => $validatedData['document_number'],
            'document_type' => $validatedData['document_type'],
            'status' => SubscriptionStatus::PENDING->value,
        ]);

        session([
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ]);

        Mail::to($validatedData['email'])->send(new ConfirmationMail($validatedData['email'], $validatedData['password']));

        $data = [
            'auth' => $this->generateAuthData(),
            'buyer' => ['email' => $user['email']],
            'reference' => $reference,
            'description' => $description,
            'expiration' => now()->addMinutes(6)->toIso8601String(),
            'ipAddress' => $request->Ip(),
            'userAgent' => $request->UserAgent(),
            'returnUrl' => route('subscription.return', [
                'slug' => $subscription->slug,
                'reference' => $reference,
                'subscription' => $subscription->getKey(),
            ]),
            'subscription' => [
                'reference' => $reference,
                'description' => $description,
            ],
        ];

        $jsonData = json_encode($data);
        $contentLength = strlen($jsonData);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            //'Content-Length' => $contentLength,
        ])->post(env('PLACETOPAY_URL'), $data);

        $result = $response->json();

        if (! $response->ok()) {
            return redirect()->route('subscription.show', ['subscription' => $subscription->id])
                ->withErrors(['subscription' => $result['status']['message']]);
        }

        return Inertia::location($result['processUrl']);
    }

    public function return(Subscription $subscription): Response
    {

        $subscription->load('site', 'plan');

        $siteName = $subscription->site ? $subscription->site->name : 'Site not found';
        $planName = $subscription->plan ? $subscription->plan->name : 'Plan not found';

        return Inertia::render('Subscription/Return', [
            'subscription' => $subscription,
            'username' => $subscription->user->name,
            'sitename' => $siteName,
            'planname' => $planName,
        ]);
    }

    private function generateAuthData(): array
    {
        $login = config('gateways.placetopay.login');
        $secretKey = config('gateways.placetopay.secret_key');
        $seed = Carbon::now()->toIso8601String();
        $rawNonce = Str::random(16);

        $tranKey = base64_encode(hash('sha256', $rawNonce.$seed.$secretKey, true));
        $nonce = base64_encode($rawNonce);

        return [
            'login' => $login,
            'tranKey' => $tranKey,
            'seed' => $seed,
            'nonce' => $nonce,
        ];
    }

    public function destroy(Subscription $Subscription): RedirectResponse
    {
        $Subscription->delete();

        return redirect()->route('subscription.index')->with('message', 'Subscription deleted successfully');
    }
}
