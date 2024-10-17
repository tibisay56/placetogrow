<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Gateways\PlacetoPayGateway;
use App\Services\Payments\PaymentService;

class RetryPaymentJob extends Job
{
    protected $subscription;

    protected $attempts;

    public function __construct(Subscription $subscription, int $attempts = 0)
    {
        $this->subscription = $subscription;
        $this->attempts = $attempts;
    }

    public function handle()
    {
        $gateway = app(PlacetoPayGateway::class);
        $payment = new Payment();
        $paymentService = new PaymentService($payment, $gateway);
        $paymentResult = $paymentService->collect($this->subscription, User::find($this->subscription->user_id));

        if ($paymentResult) {

            $invoice = $this->subscription->invoice;
            $invoice->status = 'paid';
            $invoice->save();
            $this->updateNextPaymentDate($this->subscription);
        } else {

            if ($this->attempts < config('payment.max_retries')) {
                $this->attempts++;

                RetryPaymentJob::dispatch($this->subscription, $this->attempts)
                    ->delay(now()->addDays(config('payment.retry_interval')));
            } else {
                // Manejar el caso donde se alcanzó el máximo de intentos
                // Por ejemplo, actualizar el estado de la suscripción o notificar
            }
        }
    }

    protected function updateNextPaymentDate(Subscription $subscription)
    {
        // Lógica para actualizar la próxima fecha de pago
    }
}
