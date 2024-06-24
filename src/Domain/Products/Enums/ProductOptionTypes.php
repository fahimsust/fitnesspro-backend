<?php

namespace Domain\Products\Enums;

enum ProductOptionTypes: int
{
    case Select = 1;
    case Checkbox = 2;
    case Radio = 3;
    case Image = 4;
    case DateRange = 5;

    public function label(): string
    {
        return match ($this) {
            self::Select => 'Select',
            self::Checkbox => 'Checkbox',
            self::Radio => 'Radio',
            self::Image => 'Image',
            self::DateRange => 'Date Range',
        };
    }

    public function isDateRange(): bool
    {
        return $this == self::DateRange;
    }
}
