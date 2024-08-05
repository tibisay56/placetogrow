<?php

namespace App\Http\Controllers;

use App\Constants\CurrencyType;
use App\Constants\DocumentTypes;
use App\Constants\PaymentGateway;
use App\Constants\PaymentStatus;
use App\Contracts\PaymentService;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Models\Payment;
use App\Models\Site;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Payment/Index', [
            'currencies' => CurrencyType::toArray(),
            'documentTypes' => DocumentTypes::toArray(),
            'sites' => Site::all(),
            'payments' => Payment::all(),
            'gateways' => PaymentGateway::toOptions(),
        ]);
    }

    public function store(StorePaymentRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $payment = new Payment();
        $payment->reference = date('ymdHis').'-'.strtoupper(Str::random(4));
        $payment->description = $request->description;
        $payment->amount = $request->amount;
        $payment->currency = $request->currency;
        $payment->gateway = $request->gateway;
        $payment->status = PaymentStatus::PENDING;

        $payment->payer_name = $request->name;
        $payment->payer_lastname = $request->last_name;
        $payment->payer_document_type = $request->document_type;
        $payment->payer_document_number = $request->document_number;
        $payment->payer_email = $request->email;

        $payment->site_id = $request->site_id;

        $payment->save();

        /** @var PaymentService $paymentService */
        $paymentService = app(PaymentService::class, [
            'payment' => $payment,
            'gateway' => $request->gateway,
        ]);

        $response = $paymentService->create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'document_number' => $request->document_number,
            'document_type' => $request->document_type,
        ]);

        return Inertia::location($response->url);
    }

    public function show(Payment $payment): Response
    {
        /** @var PaymentService $paymentService */
        $paymentService = app(PaymentService::class, [
            'payment' => $payment,
            'gateway' => $payment->gateway,
        ]);

        if ($payment->status === PaymentStatus::PENDING->value) {
            $payment = $paymentService->query();
        }

        return Inertia::render('Payment/Show', [
            'payment' => $payment,
        ]);
    }
}
