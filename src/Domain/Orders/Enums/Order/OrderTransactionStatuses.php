<?php

namespace Domain\Orders\Enums\Order;

enum OrderTransactionStatuses: int
{
    case Created = 0;
    case Authorized = 1;
    case Captured = 2;
    case Voided = 3;
    case AwaitingCheck = 4;
    case Pending = 5;
    case AwaitingClearance = 6;
    case Cleared = 7;
    case Approved = 8;

    public function isPaid(): bool
    {
        return in_array($this->value, [
            self::Captured,
            self::Authorized,
        ]);
    }

    public function label(): string
    {
        return match ($this) {
            default => __(implode(" ", \Str::ucsplit($this->name))),
        };
    }

    public function toOrderPaymentStatus(): OrderPaymentStatuses
    {
        return match ($this) {
            self::Voided => OrderPaymentStatuses::Failed,
            self::Captured => OrderPaymentStatuses::Paid,
            self::Authorized,
            self::Approved => OrderPaymentStatuses::Approved,
            default => OrderPaymentStatuses::Pending,
        };
    }
}
