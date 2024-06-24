<?php

namespace Domain\Discounts\Enums;

enum DiscountLevelApplyTo: int
{
    case AllProducts = 0;
    case SelectedProducts = 1;
    case NotSelectedProducts = 2;
    public function label(): string
    {
        return match ($this) {
            self::AllProducts => 'All Products',
            self::SelectedProducts => 'Products Assigned to this Level',
            self::NotSelectedProducts => 'Products Not Assigned to this Level',
        };
    }
}
