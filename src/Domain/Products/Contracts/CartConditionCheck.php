<?php

namespace Domain\Products\Contracts;

use Support\Traits\RequiresCart;

abstract class CartConditionCheck extends OrderingConditionCheck
{
    use RequiresCart;
}
