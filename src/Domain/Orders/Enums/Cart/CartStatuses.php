<?php

namespace Domain\Orders\Enums\Cart;

enum CartStatuses:int
{
    case UNKNOWN = 0;
    case ACTIVE = 1;
    case INACTIVE = 2;
}
