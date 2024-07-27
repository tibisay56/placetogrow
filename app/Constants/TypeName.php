<?php

namespace App\Constants;

enum TypeName: string
{
    case DONATIONS = 'donations';
    case INVOICING = 'invoicing';
    case SUBSCRIPTIONS = 'subscriptions';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function text(): string
    {
        return match ($this) {
            self::DONATIONS => trans('types.donations'),
            self::INVOICING => trans('types.invoicing'),
            self::SUBSCRIPTIONS => trans('types.subscriptions'),
        };
    }
}
