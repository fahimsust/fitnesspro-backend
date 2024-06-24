<?php

namespace Domain\Discounts\Contracts;

use Support\Traits\RequiresSite;

abstract class SiteConditionCheck extends DiscountConditionCheck
{
    use RequiresSite;
}
