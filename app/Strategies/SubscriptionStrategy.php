<?php

namespace App\Strategies;

class SubscriptionStrategy implements SettingsStrategy
{
    public function getFields(): array
    {
        return [
            'amount' => ['enabled' => true, 'type' => 'number'],
            'currency' => ['enabled' => true, 'type' => 'text'],

            'subscription_plan' => ['enabled' => true, 'type' => 'select', 'options' => ['Basic', 'Standard', 'Premium']],
            'subscription_start_date' => ['enabled' => true, 'type' => 'date'],
            'subscription_end_date' => ['enabled' => true, 'type' => 'date'],

            'subscriber_name' => ['enabled' => true, 'type' => 'text'],
            'subscriber_email' => ['enabled' => true, 'type' => 'email'],
            'subscriber_document_type' => ['enabled' => true, 'type' => 'select', 'options' => ['ID', 'Passport', 'Driver License']],
            'subscriber_document_number' => ['enabled' => true, 'type' => 'text'],
        ];
    }

    public function getExpirationTime(): int
    {
        return 1440;
    }
}
