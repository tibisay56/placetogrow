<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\PaymentDueNotification;
use App\Notifications\PaymentRetryNotification;
use App\Services\Gateways\PlacetoPayGateway;
use App\Services\Payments\PaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class RetryPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subscription;

    protected $attempts;

    public function __construct(Subscription $subscription, int $attempts = 0)
    {
        $this->subscription = $subscription;
        $this->attempts = $attempts;
    }

    public function handle(): void
    {
        if ($this->subscription->status === 'failed') {
            $this->subscription->increment('retry_count');
            $this->subscription->increment('payment_attempts');

            $gateway = app(PlacetoPayGateway::class);
            $payment = new Payment();
            $paymentService = new PaymentService($payment, $gateway);
            $paymentResult = $paymentService->collect($this->subscription, User::find($this->subscription->user_id));

            if ($paymentResult) {
                $this->handleSuccessfulPayment();
            } else {
                $this->handleFailedPayment();
            }
        } else {
            throw new \Exception('La suscripción no está en estado fallido.');
        }
    }

    protected function handleSuccessfulPayment(): void
    {
        $invoice = $this->subscription->invoices()->latest()->first();

        if ($invoice) {
            $invoice->status = 'paid';
            $invoice->save();
        }

        $this->updateNextPaymentDate($this->subscription);
    }

    protected function handleFailedPayment(): void
    {
        if ($this->attempts < config('payment.max_retries')) {

            $this->subscription->next_retry_at = now()->addDays(config('payment.retry_interval'));
            $this->subscription->save();

            Notification::send($this->subscription->user, new PaymentRetryNotification($this->subscription, $this->attempts));

            RetryPaymentJob::dispatch($this->subscription, $this->attempts)
                ->delay(now()->addDays(config('payment.retry_interval')));
        } else {
            Notification::send($this->subscription->user, new PaymentDueNotification($this->subscription));

            $this->subscription->status = 'failed';
            $this->subscription->save();
        }
    }

    protected function updateNextPaymentDate(Subscription $subscription)
    {
        $subscription->next_billing_date = now()->addMonth();
        $subscription->save();
    }
}
