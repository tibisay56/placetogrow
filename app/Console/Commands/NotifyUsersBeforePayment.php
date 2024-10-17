<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Notifications\PaymentDueNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifyUsersBeforePayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:before-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users before subscription payments are due';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptions = Subscription::where('next_billing_date', '<=', Carbon::now()->addDays(3))
            ->where('notified_before_charge', false)
            ->where('status', 'approved')
            ->get();

        foreach ($subscriptions as $subscription) {

            $subscription->user->notify(new PaymentDueNotification($subscription));

            $subscription->notified_before_charge = true;
            $subscription->save();

            $this->info('Notification sent to user ID: '.$subscription->user->id);
        }

        $this->info('Notifications have been sent successfully.');

        return Command::SUCCESS;
    }
}
