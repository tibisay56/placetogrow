<?php

namespace App\Constants;

enum PlanTypeName: string
{
    case BASIC = 'basic';
    case MEDIUM = 'medium';
    case PREMIUM = 'premium';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function text(): string
    {
        return match ($this) {
            self::BASIC => trans('types.basic'),
            self::MEDIUM => trans('types.medium'),
            self::PREMIUM => trans('types.premium'),
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::BASIC => 'Ideal for individuals.',
            self::MEDIUM => 'Perfect for small teams.',
            self::PREMIUM => 'Best for large organizations.',
        };
    }
}
