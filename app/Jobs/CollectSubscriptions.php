<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Gateways\PlacetoPayGateway;
use App\Services\Payments\PaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CollectSubscriptions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info('Starting subscription collection...');

        $subscriptions = Subscription::where('status', 'approved')->get();

        if ($subscriptions->isEmpty()) {
            info('No active subscriptions found.');

            return;
        }

        foreach ($subscriptions as $subscription) {
            info("Processing subscription ID: {$subscription->id}");

            $plan = $subscription->plan;
            if (! $plan) {
                info("Plan not found for subscription ID: {$subscription->id}");

                continue;
            }

            $invoice = Invoice::where('subscription_id', $subscription->id)
                ->where('status', 'pending')
                ->first();

            if (! $invoice) {
                info("No pending invoices for subscription ID: {$subscription->id}");

                continue;
            }

            if ($this->isTimeToCollect($subscription, $plan)) {
                info("Successful charge for subscription ID: {$subscription->id}");

                $payment = new Payment();
                $gateway = app(PlacetoPayGateway::class);
                $paymentService = new PaymentService($payment, $gateway);

                $paymentService->collect($subscription, User::find($subscription->user_id));

                $invoice->status = 'paid';
                $invoice->save();

                $subscription->last_collected_at = now()->subYear();
                $subscription->save();

                info("Payment recorded and invoice updated for subscription ID: {$subscription->id}");
            } else {
                info("It's not time to collect for subscription ID: {$subscription->id}");
            }
        }

        info('Subscription collection job executed successfully');
    }

    protected function isTimeToCollect(Subscription $subscription, $plan): bool
    {
        $billingFrequency = $plan->billing_frequency;
        $lastCollectedAt = $subscription->last_collected_at;

        switch ($billingFrequency) {
            case 'yearly':
                return now()->diffInDays($lastCollectedAt) >= 365;
            case 'monthly':
                return now()->diffInDays($lastCollectedAt) >= 30;
            case 'weekly':
                return now()->diffInDays($lastCollectedAt) >= 7;
            case 'daily':
                return now()->diffInDays($lastCollectedAt) >= 1;
            default:
                return false;
        }
    }
}
