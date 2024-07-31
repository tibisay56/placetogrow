<?php

namespace App\Strategies;

class InvoiceStrategy implements SettingsStrategy
{
    public function getFields(): array
    {
        return [
            'amount' => ['enabled' => true, 'type' => 'number'],
            'currency' => ['enabled' => true, 'type' => 'text'],

            'invoice_number' => ['enabled' => true, 'type' => 'text'],
            'invoice_date' => ['enabled' => true, 'type' => 'date'],
            'billing_name' => ['enabled' => true, 'type' => 'text'],
            'billing_email' => ['enabled' => true, 'type' => 'email'],
            'billing_document_type' => ['enabled' => true, 'type' => 'select', 'options' => ['ID', 'Passport', 'Driver License']],
            'billing_document_number' => ['enabled' => true, 'type' => 'text'],
        ];
    }

    public function getExpirationTime(): int
    {
        return 1440;
    }
}
