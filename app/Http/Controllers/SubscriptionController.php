<?php

namespace App\Http\Controllers;

use App\Constants\BillingFrequency;
use App\Constants\CurrencyType;
use App\Constants\DocumentTypes;
use App\Constants\SubscriptionStatus;
use App\Http\Requests\Subscription\StoreRequest;
use App\Jobs\RetryPaymentJob;
use App\Mail\ConfirmationMail;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Site;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Gateways\PlacetoPayGateway;
use App\Services\Payments\PaymentService;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
            $subscriptions = Subscription::with(['plan', 'site'])->get();
        } else {
            $subscriptions = Subscription::with(['plan', 'site'])
                ->where('user_id', $user->id)
                ->get();
        }

        return Inertia::render('Subscription/Index', [
            'subscriptions' => $subscriptions,
            'sites' => Site::all(),
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

    public function store(StoreRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $validatedData = $request->validated();

        $planId = $validatedData['plan_id'];
        $plan = Plan::find($planId);

        $description = 'Plan '.$plan->type.' COP $'.$plan->amount;
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

        $site = Site::find($validatedData['site_id']);
        if (! $site) {
            throw new \Exception('Site not found.');
        }

        $subscription = Subscription::query()->create([
            'reference' => $reference,
            'site_id' => $site->getKey(),
            'user_id' => $user->getKey(),
            'email' => $validatedData['email'],
            'plan_id' => $validatedData['plan_id'],
            'name' => $validatedData['name'],
            'surname' => $validatedData['surname'],
            'document_number' => $validatedData['document_number'],
            'document_type' => $validatedData['document_type'],
            'status' => SubscriptionStatus::PENDING->value,
        ]);

        session([
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ]);

        //Mail::to($validatedData['email'])->send(new ConfirmationMail($validatedData['email'], $validatedData['password']));

        $data = [
            'auth' => $this->generateAuthData(),
            'buyer' => [
                'email' => $user['email'],
                'name' => $user['name'],
                'surname' => $user['surname'],
                'document' => $user['document'],
                'documentType' => 'CC',
                'mobile' => $user['mobile'],
            ],
            'reference' => $reference,
            'description' => $description,
            'expiration' => now()->addMinutes(6)->toIso8601String(),
            'ipAddress' => $request->Ip(),
            'userAgent' => $request->UserAgent(),
            'returnUrl' => route('subscription.return', [
                'site' => $site->slug,
                'reference' => $reference,
                'subscription' => $subscription->getKey(),
            ]),
            'subscription' => [
                'reference' => $reference,
                'description' => $description,
            ],
        ];

        $response = Http::post(env('PLACETOPAY_URL'), $data);

        $result = $response->json();

        if (! $response->ok()) {
            return redirect()->route('subscription.show', $site->slug)
                ->withErrors(['subscription' => $result['status']['message']]);
        }
        $subscription->update([
            'request_id' => $result['requestId'],
            'process_url' => $result['processUrl'],
            'status_message' => $result['status']['message'],
        ]);

        return Inertia::location($result['processUrl']);
    }

    public function return(Subscription $subscription): Response
    {

        $subscription->load('site', 'plan');

        $siteName = $subscription->site ? $subscription->site->name : 'Site not found';
        $planName = $subscription->plan ? $subscription->plan->name : 'Plan not found';

        $sessionInformationResponse = Http::post(env('PLACETOPAY_URL').'/'.$subscription->request_id, [
            'auth' => $this->generateAuthData(),
        ]);

        Log::info('Response from Placetopay:', $sessionInformationResponse->json());

        $subscription->update([
            'status' => $sessionInformationResponse['status']['status'],
            'token' => $sessionInformationResponse['subscription']['instrument'][0]['value'],
            'sub_token' => $sessionInformationResponse['subscription']['instrument'][1]['value'],
        ]);

        if ($subscription->status === 'APPROVED') {
            $this->createInvoiceForSubscription($subscription, $sessionInformationResponse);
            $this->createPaymentTransaction($subscription, $sessionInformationResponse);

            $this->chargeUsingToken($subscription);
        }

        return Inertia::render('Subscription/Return', [
            'subscription' => $subscription,
            'username' => $subscription->user->name,
            'sitename' => $siteName,
            'planname' => $planName,
        ]);
    }

    public function chargeUsingToken(Subscription $subscription): void
    {
        $paymentReference = 'PAY_'.strtoupper(Str::random(8));

        $data = [
            'auth' => $this->generateAuthData(),
            'payment' => [
                'reference' => $paymentReference,
                'description' => 'Cobro automático para la suscripción al plan: '.$subscription->plan->name,
                'amount' => [
                    'currency' => CurrencyType::COP->name,
                    'total' => $subscription->plan->amount,
                ],
            ],
            'buyer' => [
                'name' => $subscription->user->name,
                'surname' => $subscription->user->surname ?? 'No aplica',
                'email' => $subscription->user->email,
                'document' => '54534534',
                'documentType' => 'CC',
                'mobile' => $subscription->user->phone ?? '',
            ],
            'payer' => [
                'name' => $subscription->user->name,
                'surname' => $subscription->user->surname ?? 'No aplica',
                'email' => $subscription->user->email,
                'document' => '4243242',
                'documentType' => 'CC',
                'mobile' => $subscription->user->phone ?? '',
            ],
            'instrument' => [
                'token' => [
                    'token' => $subscription->token,
                ],
            ],
            'expiration' => now()->addMonth()->toIso8601String(),
            'returnUrl' => route('subscription.return', [
                'site' => $subscription->site->slug,
                'reference' => $paymentReference,
                'subscription' => $subscription->getKey(),
            ]),
            'ipAddress' => request()->ip(),
            'userAgent' => request()->userAgent(),
        ];

        Log::info('Sending payment data to PlacetoPay:', $data);

        $response = Http::post(env('PLACETOPAY_COLLECT_URL'), $data);

        Log::info('Response from PlacetoPay:', $response->json());

        if ($response->successful()) {
            Log::info('Cobro realizado con éxito', $response->json());

            $this->createPaymentTransaction($subscription, $response->json());
        } else {
            Log::error('Error al realizar el cobro: '.$response->body());
            throw new \Exception('Error al realizar el cobro usando el token.');
        }
    }

    public function createInvoiceForSubscription(Subscription $subscription, $sessionInformationResponse): void
    {
        $now = Carbon::now();
        $reference = $now->format('ymd').'-'.strtoupper(Str::random(6));
        $invoiceStatus = ($subscription->status === 'APPROVED') ? 'paid' : 'pending';

        $existingInvoice = Invoice::where('subscription_id', $subscription->id)->first();
        if ($existingInvoice) {
            Log::info('Invoice already exists for this subscription. Skipping invoice creation.');

            return;
        }

        Invoice::create([
            'reference' => $reference,
            'amount' => $subscription->plan->amount,
            'currency' => CurrencyType::COP->name,
            'customer_name' => $subscription->user->name,
            'dni' => str_pad(7, '7', STR_PAD_LEFT),
            'description' => 'Descripción de la suscripción al plan '.$subscription->plan->name,
            'created_at' => $now->toDateTimeString(),
            'expired_at' => $now->addMonth()->toDateTimeString(),
            'status' => $invoiceStatus,
            'subscription_id' => $subscription->id,
            'site_id' => $subscription->site_id,
            'user_id' => $subscription->user_id,
        ]);
    }

    public function createPaymentTransaction(Subscription $subscription, $sessionInformationResponse): void
    {
        $paymentReference = 'PAY_'.strtoupper(Str::random(8));

        $existingPayment = Payment::where('subscription_id', $subscription->id)->first();
        if ($existingPayment) {
            Log::info('Payment already exists for this subscription. Skipping payment creation.');

            return;
        }

        Payment::create([
            'reference' => $paymentReference,
            'amount' => $subscription->plan->amount,
            'currency' => CurrencyType::COP->name,
            'status' => $sessionInformationResponse['status']['status'],
            'description' => 'Payment for subscription to plan: '.$subscription->plan->name,
            'transaction_id' => $sessionInformationResponse['requestId'],
            'subscription_id' => $subscription->id,
            'user_id' => $subscription->user_id,
            'site_id' => $subscription->site_id,
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

    public function destroy(Subscription $subscription): RedirectResponse
    {
        if ($subscription->token) {
            $this->invalidateToken($subscription->token);
        } else {
            Log::info("No token to invalidate for subscription ID: {$subscription->id}");
        }

        $subscription->delete();

        return redirect()->route('subscription.index')->with('message', 'Subscription deleted successfully');
    }

    protected function invalidateToken(string $token): void
    {
        $authData = $this->generateAuthData();

        $data = [
            'auth' => $authData,
            'locale' => 'en_US',
            'instrument' => [
                'token' => [
                    'token' => $token,
                ],
            ],
        ];

        $response = Http::post(env('PLACETOPAY_INVALIDATE_URL').'/api/instrument/invalidate', $data);

        if (! $response->successful()) {
            Log::error('Failed to invalidate token: '.$response->body());
            throw new \Exception('Could not invalidate the token. Please try again later.');
        }
    }
    
    public function paySubscription(Subscription $subscription, Request $request): \Illuminate\Http\JsonResponse
    {
        $user = User::find($subscription->user_id);

        $gateway = app(PlacetoPayGateway::class);
        $payment = new Payment();
        $paymentService = new PaymentService($payment, $gateway);

        $paymentResult = $paymentService->collect($subscription, $user);

        if ($paymentResult) {
            return response()->json(['message' => 'Payment successful']);
        } else {
            RetryPaymentJob::dispatch($subscription);
            return response()->json(['message' => 'Payment failed, retrying...']);
        }
    }

    public function retryPayment(Subscription $subscription): \Illuminate\Http\JsonResponse
    {
        if ($subscription->status !== 'pending') {
            return response()->json(['message' => 'Payment retry not needed'], 400);
        }

        RetryPaymentJob::dispatch($subscription);
        return response()->json(['message' => 'Retry payment job dispatched']);
    }
}
