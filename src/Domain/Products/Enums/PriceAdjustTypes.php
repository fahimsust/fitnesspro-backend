<?php

namespace Domain\Products\Enums;

enum PriceAdjustTypes: int
{
    case AMOUNT = 1;
    case PERCENTAGE = 2;
}
