<?php

namespace Domain\Products\Actions\OrderingRules;

use Domain\Products\Models\OrderingRules\OrderingCondition;
use Lorisleiva\Actions\Concerns\AsObject;

class AddItemToOrderingCondition
{
    use AsObject;

    public function handle(
        OrderingCondition $orderingCondition,
        int $itemId
    ) {
        if (CheckIfItemExistsInOrderingCondition::run($orderingCondition, $itemId)) {
            throw new \Exception(__('Item is already added in ordering condition'));
        }

        return $orderingCondition->orderingConditionItem()->create([
            'item_id' => $itemId,
        ]);
    }
}
