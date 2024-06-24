<?php

namespace Domain\Orders\Enums\Order;

enum OrderStatuses: string
{
    case Recorded = 'recorded';
    case PaymentArranged = 'payment_arranged';
    case Completed = 'completed';

    case Unknown = "";

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

    public function readyToPay(): bool
    {
        return $this != self::Recorded;
    }

    public function readyToComplete(): bool
    {
        return $this == self::PaymentArranged;
    }
}
