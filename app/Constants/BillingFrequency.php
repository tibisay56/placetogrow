<?php

namespace App\Constants;

enum BillingFrequency: string
{
    case MONTHLY = 'monthly';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
