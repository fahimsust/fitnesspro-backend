<?php

namespace Domain\Payments\Enums;

enum PaymentMethodStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;
}
