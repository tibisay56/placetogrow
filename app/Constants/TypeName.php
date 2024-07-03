<?php

namespace App\Constants;

enum TypeName: string
{
    case BASIC = 'basic';
    case INVOICING = 'invoicing';
    case SUBSCRIPTIONS = 'subscriptions';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function text(): string
    {
        return match ($this) {
            self::BASIC => trans('types.basic'),
            self::INVOICING => trans('types.invoicing'),
            self::SUBSCRIPTIONS => trans('types.subscriptions'),
        };
    }
}
