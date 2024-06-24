<?php

namespace Domain\Accounts\Enums;

use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Enums\Cart\CartStatuses;

enum RegistrationStatus: int
{
    case OPEN = 1;
    case CLOSE = 0;

    public static function IsOpen(Registration $registration): bool
    {
        return $registration->status === self::OPEN;
    }

    public function toCartStatus(): CartStatuses
    {
        return match ($this) {
            self::OPEN => CartStatuses::ACTIVE,
            self::CLOSE => CartStatuses::INACTIVE,
        };
    }
}
