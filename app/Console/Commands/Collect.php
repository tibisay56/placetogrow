<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Gateways\PlacetoPayGateway;
use App\Services\Payments\PaymentService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Collect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:collect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically collect subscription payments';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $today = Carbon::today();
        $subscriptions = Subscription::where('next_payment_at', $today)
            ->where('status', 'approved')
            ->get();

        if ($subscriptions->isEmpty()) {
            $this->info('No subscriptions found for today.');

            return Command::SUCCESS;
        }

        foreach ($subscriptions as $subscription) {
            $payment = new Payment();
            $gateway = app(PlacetoPayGateway::class);
            $paymentService = new PaymentService($payment, $gateway);

            $paymentResult = $paymentService->collect($subscription, User::find($subscription->user_id));

            if ($paymentResult) {
                $invoice = $subscription->invoice;
                $invoice->status = 'paid';
                $invoice->save();

                switch ($subscription->plan->billing_frequency) {
                    case 'daily':
                        $subscription->next_payment_at = $today->addDay();
                        break;
                    case 'weekly':
                        $subscription->next_payment_at = $today->addWeek();
                        break;
                    case 'monthly':
                        $subscription->next_payment_at = $today->addMonth();
                        break;
                    case 'yearly':
                        $subscription->next_payment_at = $today->addYear();
                        break;
                }
                $subscription->save();

                $this->info("Payment collected and invoice updated for subscription ID: {$subscription->id}");
            } else {
                $this->error("Payment failed for subscription ID: {$subscription->id}");
            }
        }

        $this->info('Collection command executed successfully');

        return Command::SUCCESS;
    }
}
