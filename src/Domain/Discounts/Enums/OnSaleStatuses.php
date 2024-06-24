<?php

namespace Domain\Discounts\Enums;

enum OnSaleStatuses: int
{
    case OnSale = 1;
    case NotOnSale = 0;

    public function isOnSale(): bool
    {
        return $this === self::OnSale;
    }
}
