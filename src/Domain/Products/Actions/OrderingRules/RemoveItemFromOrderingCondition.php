<?php

namespace Domain\Products\Actions\OrderingRules;

use Domain\Products\Models\OrderingRules\OrderingCondition;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveItemFromOrderingCondition
{
    use AsObject;

    public function handle(
        OrderingCondition $orderingCondition,
        int $itemId
    ) {
        if (! CheckIfItemExistsInOrderingCondition::run($orderingCondition, $itemId)) {
            throw new \Exception(__("Can't delete : Item is not added to ordering condition"));
        }

        $orderingCondition->orderingConditionItem()->whereItemId($itemId)->delete();
    }
}
