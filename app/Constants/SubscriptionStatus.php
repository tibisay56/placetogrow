<?php

namespace App\Constants;

enum SubscriptionStatus: string
{
    case APPROVED = 'approved';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';
    case EXPIRED = 'expired';
    case CANCELLED = 'cancelled';
    case SUSPENDED = 'suspended';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function text(): string
    {
        return match ($this) {
            self::APPROVED => trans('subscriptions.status.approved'),
            self::ACTIVE => trans('subscriptions.status.active'),
            self::INACTIVE => trans('subscriptions.status.inactive'),
            self::PENDING => trans('subscriptions.status.pending'),
            self::EXPIRED => trans('subscriptions.status.expired'),
            self::CANCELLED => trans('subscriptions.status.cancelled'),
            self::SUSPENDED => trans('subscriptions.status.suspended'),
        };
    }
}
