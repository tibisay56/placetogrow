<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentRetryNotification extends Notification
{
    use Queueable;

    protected $subscription;

    protected $attempts;

    /**
     * Create a new notification instance.
     */
    public function __construct($subscription, $attempts)
    {
        $this->subscription = $subscription;
        $this->attempts = $attempts;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Payment Retry Attempt Notification.')
            ->greeting('Hello '.$notifiable->name)
            ->line('We are attempting to process your payment for the subscription to '.$this->subscription->plan->name.'.')
            ->line('This is attempt number '.$this->attempts.'.')
            ->line('If this payment is successful, your subscription will continue without interruption.')
            ->line('Thank you for your patience!')
            ->action('View Subscription', url('/subscriptions'))
            ->line('If you have any questions, feel free to contact us.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'attempts' => $this->attempts,
        ];
    }
}
