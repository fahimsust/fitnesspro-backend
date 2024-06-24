<?php

namespace Domain\Discounts\Actions;

use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;

abstract class AbstractApplyDiscountCodeAction
{
    public DiscountCondition $condition;

    protected function findDiscountCondition(string $discountCode)
    {
        return FindDiscountConditionByCode::run($discountCode);
    }

    protected function findDiscount(string $discountCode): Discount
    {
        return FindDiscountByCode::run($discountCode);
    }
}
