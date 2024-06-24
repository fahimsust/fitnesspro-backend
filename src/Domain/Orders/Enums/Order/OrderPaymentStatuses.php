<?php

namespace Domain\Orders\Enums\Order;

enum OrderPaymentStatuses: string
{
    case Pending = 'pending';
    case InTransit = 'in_transit';
    case Approved = 'approved';
    case Failed = 'failed';
    case Paid = 'paid';
    case PartiallyPaid = 'partially_paid';

    public function label(): string
    {
        return match ($this) {
            default => __(implode(" ", \Str::ucsplit($this->name))),
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->map(
                fn(self $status) => [
                    'id' => $status,
                    'name' => $status->label()
                ]
            )
            ->toArray();
    }
}
