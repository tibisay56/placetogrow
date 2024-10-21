<?php

namespace App\Console\Commands;

use App\Jobs\RetryPaymentJob;
use App\Models\Subscription;
use Illuminate\Console\Command;

class RetryPaymentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:retry-payment {subscriptionId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retry the payment for a subscription';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptionId = $this->argument('subscriptionId');
        $subscription = Subscription::with('invoices')->find($subscriptionId);

        if (! $subscription) {
            $this->error('Subscription not found.');

            return;
        }

        if (! ($subscription instanceof Subscription)) {
            $this->error('Expected a Subscription instance.');

            return;
        }

        $job = new RetryPaymentJob($subscription);
        $job->handle();

        $this->info('Payment retry job executed successfully.');
    }
}
