<?php

namespace App\Api\Admin\OrderingRules\Controllers;

use App\Api\Admin\OrderingRules\Requests\OrderingRuleChildRequest;
use App\Api\Admin\OrderingRules\Requests\OrderingRuleKeywordSearchRequest;
use Domain\Products\Actions\OrderingRules\AssignChildRuleToOrderingRule;
use Domain\Products\Actions\OrderingRules\RemoveChildRuleFromOrderingRule;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderingRuleChildController extends AbstractController
{
    public function index(OrderingRule $orderingRule, OrderingRuleKeywordSearchRequest $request)
    {
        return response(
            OrderingRule::query()
                ->availableToAssignAsChild($orderingRule, $request->keyword)
                ->get(),
            Response::HTTP_OK
        );
    }

    public function store(OrderingRule $orderingRule, OrderingRuleChildRequest $request)
    {
        return response(
            AssignChildRuleToOrderingRule::run($orderingRule, $request->child_rule_id),
            Response::HTTP_CREATED
        );
    }

    public function destroy(OrderingRule $orderingRule, int $child)
    {
        return response(
            RemoveChildRuleFromOrderingRule::run($orderingRule, $child),
            Response::HTTP_OK
        );
    }
}
