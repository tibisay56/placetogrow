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
    protected $signature = 'app:retry-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retry the payment for all subscriptions with failed payments';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        $subscriptions = Subscription::where('status', 'failed')->get();

        foreach ($subscriptions as $subscription) {
            $job = new RetryPaymentJob($subscription, 0);
            dispatch($job);
        }

        $this->info('Payment retry job executed successfully.');
    }
}
