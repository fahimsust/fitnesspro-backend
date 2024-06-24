<?php

namespace Domain\Discounts\Actions;

use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Lorisleiva\Actions\Concerns\AsObject;

class FindDiscountConditionByCode
{
    use AsObject;

    public function handle(string $discountCode): DiscountCondition
    {
        try {
            return DiscountCondition::whereRequiredCode($discountCode)
                ->with('rule.discount')
                ->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new \Exception(__('Discount code not found'));
        }
    }
}
