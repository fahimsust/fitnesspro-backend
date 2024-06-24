<?php

namespace App\Api\Admin\OrderingRules\Controllers;

use App\Api\Admin\OrderingRules\Requests\OrderingRuleKeywordSearchRequest;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderingRuleChildrenController extends AbstractController
{
    public function __invoke(OrderingRule $orderingRule, OrderingRuleKeywordSearchRequest $request)
    {
        return response(
            OrderingRule::query()
                ->availableToAssignAsChild($orderingRule, $request->keyword)
                ->get(),
            Response::HTTP_OK
        );
    }
}
