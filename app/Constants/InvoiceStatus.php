<?php

namespace App\Constants;

enum InvoiceStatus: string
{
    case PENDING = 'pending';
    case OVERDUE = 'overdue';
    case PAID = 'paid';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function text(): string
    {
        return match ($this) {
            self::PENDING => trans('subscriptions.status.pending'),
            self::OVERDUE => trans('subscriptions.status.overdue'),
            self::PAID => trans('subscriptions.status.paid'),
        };
    }
}
