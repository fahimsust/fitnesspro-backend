<?php

namespace Domain\Products\Actions\OrderingRules;

use Domain\Products\Models\OrderingRules\OrderingCondition;
use Domain\Products\Models\OrderingRules\OrderingConditionItem;
use Lorisleiva\Actions\Concerns\AsObject;

class CheckIfItemExistsInOrderingCondition
{
    use AsObject;

    public function handle(
        OrderingCondition $orderingCondition,
        int $itemId
    ): ?OrderingConditionItem {
        return $orderingCondition->orderingConditionItem()
            ->whereItemId($itemId)
            ->first();
    }
}
