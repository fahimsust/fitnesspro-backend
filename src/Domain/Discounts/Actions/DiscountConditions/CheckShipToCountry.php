<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\CartConditionCheck;

class CheckShipToCountry extends CartConditionCheck
{
    public function check(): bool
    {
        //Todo Check the shipping country
        return true;
    }
}
