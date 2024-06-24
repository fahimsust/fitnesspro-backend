<?php

namespace Domain\Discounts\Enums;

enum DiscountConditionRequiredQtyTypes: int
{
    case Combined = 0;
    case Individual = 1;

    public function isCombined(): bool
    {
        return $this === self::Combined;
    }
}
