<?php

namespace App\Api\Admin\OrderingRules\Controllers;

use App\Api\Admin\OrderingRules\Requests\OrderingConditionItemRequest;
use Domain\Products\Actions\OrderingRules\AddItemToOrderingCondition;
use Domain\Products\Actions\OrderingRules\RemoveItemFromOrderingCondition;
use Domain\Products\Models\OrderingRules\OrderingCondition;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderingConditionItemController extends AbstractController
{
    public function store(OrderingCondition $orderingCondition, OrderingConditionItemRequest $request)
    {
        return response(
            AddItemToOrderingCondition::run($orderingCondition, $request->item_id),
            Response::HTTP_CREATED
        );
    }

    public function destroy(OrderingCondition $orderingCondition, int $item_id)
    {
        return response(
            RemoveItemFromOrderingCondition::run($orderingCondition, $item_id),
            Response::HTTP_OK
        );
    }
}
