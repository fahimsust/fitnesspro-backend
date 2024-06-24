<?php

namespace Domain\Orders\Enums\Checkout;

enum CheckoutStatuses: string
{
    case Init = 'init';
    case Completed = 'completed';

    public function isCompleted(): bool
    {
        return $this == self::Completed;
    }

    public function label(): string
    {
        return match ($this) {
            self::Init => 'Initiated',
            default => ucfirst($this->value)
        };
    }
}
