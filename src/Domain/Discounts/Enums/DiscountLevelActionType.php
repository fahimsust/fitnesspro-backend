<?php

namespace Domain\Discounts\Enums;

enum DiscountLevelActionType: int
{
    case Percentage = 0;
    case SitePricing = 1;
    public function label(): string
    {
        return match ($this) {
            self::Percentage => 'percentage',
            self::SitePricing => 'site pricing'
        };
    }
}
