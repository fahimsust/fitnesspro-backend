<?php

namespace App\Api\Admin\OrderingRules\Controllers;

use App\Api\Admin\OrderingRules\Requests\OrderingConditionRequest;
use App\Api\Admin\OrderingRules\Requests\OrderingConditionUpdateRequest;
use Domain\Products\Models\OrderingRules\OrderingCondition;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Support\Controllers\AbstractController;
use Support\Enums\MatchAllAnyString;
use Symfony\Component\HttpFoundation\Response;

class OrderingConditionController extends AbstractController
{
    public function store(OrderingConditionRequest $request)
    {
        return response(
            OrderingCondition::Create([
                'rule_id' => $request->rule_id,
                'type' => $request->type,
                'any_all'=>MatchAllAnyString::ANY,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function update(
        OrderingCondition $orderingCondition,
        OrderingConditionUpdateRequest $request
    ) {
        return response(
            $orderingCondition->update([
                'any_all' => $request->any_all,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function destroy(OrderingCondition $orderingCondition)
    {
        return response(
            $orderingCondition->delete(),
            Response::HTTP_OK
        );
    }
}
