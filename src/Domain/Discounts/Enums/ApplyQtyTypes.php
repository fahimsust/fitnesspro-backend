<?php

namespace Domain\Discounts\Enums;

enum ApplyQtyTypes: int
{
    case COMBINED = 0;
    case INDIVIDUAL = 1;

    public function isCombined(): bool
    {
        return $this === self::COMBINED;
    }
}
