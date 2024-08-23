<?php

namespace App\Constants;

enum BillingFrecuency: string
{
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
