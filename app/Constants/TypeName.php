<?php

namespace App\Constants;

enum TypeName: string
{
    case BASIC = 'Basic';
    case INVOICING = 'Invoicing';
    case SUBSCRIPTIONS = 'Subscriptions';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function text(): string
    {
        return match ($this) {
            self::BASIC => trans('types.Basic'),
            self::INVOICING => trans('types.Invoicing'),
            self::SUBSCRIPTIONS => trans('types.Subscriptions'),
        };
    }
}
