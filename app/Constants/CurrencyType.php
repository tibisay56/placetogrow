<?php

namespace App\Constants;

final class CurrencyType
{
    public const COP = 'COP';
    public const USD = 'USD';

    public static function toArray(): array
    {
        return [
            self::COP => 'COP',
            self::USD => 'USD',
        ];
    }

    public static function text(string $value): string
    {
        switch ($value) {
            case self::COP:
                return trans('currencies.cop');
            case self::USD:
                return trans('currencies.usd');
            default:
                return '';
        }
    }
}
