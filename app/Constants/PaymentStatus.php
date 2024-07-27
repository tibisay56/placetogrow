<?php

namespace App\Constants;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case APPROVED_PARTIAL = 'approved_partial';
    case PARTIAL_EXPIRED = 'partial_expired';
    case UNKNOWN = 'unknown';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function text(): string
    {
        return match ($this) {
            self::PENDING => trans('payments.status.pending'),
            self::APPROVED => trans('payments.status.approved'),
            self::REJECTED => trans('payments.status.rejected'),
            self::APPROVED_PARTIAL => trans('payments.approved.partial'),
            self::PARTIAL_EXPIRED => trans('payments.partial.expired'),
            self::UNKNOWN => trans('payments.status.unknown'),
        };
    }
}
