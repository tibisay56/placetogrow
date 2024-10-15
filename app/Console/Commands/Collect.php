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
        $subscriptions = Subscription::where('status', 'approved')
        ->whereHas('invoices', function ($query) {
            $query->whereIn('status', ['pending', 'overdue']);
        })
            ->where('next_billing_date', '<=', Carbon::now())
            ->get();

        if ($subscriptions->isEmpty()) {
            $this->info('No subscriptions due for collection.');
            return Command::SUCCESS;
        }

        foreach ($subscriptions as $subscription) {
            $invoice = $subscription->invoices()->whereIn('status', ['pending', 'overdue'])->latest()->first();

            if ($invoice) {
                $payment = new Payment();
                $gateway = app(PlacetoPayGateway::class);
                $paymentService = new PaymentService($payment, $gateway);
                $paymentResult = $paymentService->collect($subscription, User::find($subscription->user_id));

                if ($paymentResult) {
                    $this->info('Payment collected successfully for subscription ID: ' . $subscription->id);

                    $subscription->next_billing_date = Carbon::now()->addMonth();
                    $subscription->months_charged += 1;
                    $subscription->save();

                    $invoice->status = 'paid';
                    $invoice->save();
                } else {
                    $this->error('Payment collection failed for subscription ID: ' . $subscription->id);
                }
            } else {
                $this->info('No pending or overdue invoices for subscription ID: ' . $subscription->id);
            }
        }

        $this->info('Collect test data command executed');

        return Command::SUCCESS;
    }
}
