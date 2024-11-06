<?php

namespace App\Services\Payments;

use App\Constants\PaymentStatus;
use App\Contracts\PaymentGateway;
use App\Contracts\PaymentService as PaymentServiceContract;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentService implements PaymentServiceContract
{
    public function __construct(
        protected Payment $payment,
        protected PaymentGateway $gateway,
    ) {
    }

    public function collect(Subscription $subscription, User $user)
    {
        $payment = Payment::create([
            'reference' => now()->format('ymdHis').'-'.strtoupper(Str::random(4)),
            'subscription_id' => $subscription->id,
            'user_id' => $user->id,
            'amount' => $subscription->plan->amount,
            'currency' => $subscription->plan->currency,
            'description' => $subscription->plan->description,
            'status' => PaymentStatus::APPROVED->value,
            'site_id' => $subscription->site->id,
            'collect' => true,
        ]);

        $response = $this->gateway->prepare()
            ->payment($payment)
            ->process();

        $payment->update([
            'process_identifier' => $response->processIdentifier,
            'status' => $response->status,
            'collect' => true,
        ]);

        return $payment;
    }

    public function create(array $buyer): PaymentResponse
    {
        $response = $this->gateway->prepare()
            ->buyer($buyer)
            ->payment($this->payment)
            ->process();

        if ($response->status === 'error') {

            Log::error('Error processing the payment', ['response' => $response]);
            throw new \Exception('Error processing the payment');
        }

        $this->payment->update([
            'process_identifier' => $response->processIdentifier,
            'status' => $response->status,
        ]);

        return $response;
    }

    public function query(): Payment
    {
        $response = $this->gateway->prepare()
            ->get($this->payment);

        Log::info('Payment status response from gateway', [
            'payment_id' => $this->payment->id,
            'response' => $response,
        ]);

        return tap($this->payment)->update([
            'status' => $response->status,
        ]);
    }
}
