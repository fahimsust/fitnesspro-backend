<?php

namespace Domain\Discounts\Contracts;

use Support\Traits\RequiresCart;

abstract class CartConditionCheck extends DiscountConditionCheck
{
    use RequiresCart;
}
