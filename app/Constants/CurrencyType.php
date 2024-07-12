<?php

namespace App\Constants;

enum CurrencyType: string
{
    case USD = 'USD';
    case COP = 'COP';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function text(): string
    {
        return match ($this) {
            self::USD => trans('currencies.usd'),
            self::COP => trans('currencies.cop'),
        };
    }
}
