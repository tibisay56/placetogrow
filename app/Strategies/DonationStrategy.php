<?php

namespace App\Strategies;

class DonationStrategy implements SettingsStrategy
{
    public function getFields(): array
    {
        return [
            'amount' => ['enabled' => true, 'type' => 'number'],
            'currency' => ['enabled' => true, 'type' => 'text'],

            'donor_name' => ['enabled' => true, 'type' => 'text'],
            'donor_email' => ['enabled' => true, 'type' => 'email'],
            'donor_document_type' => ['enabled' => true, 'type' => 'select', 'options' => ['ID', 'Passport', 'Driver License']],
            'donor_document_number' => ['enabled' => true, 'type' => 'text'],

        ];
    }

    public function getExpirationTime(): int
    {
        return 1440;
    }
}
