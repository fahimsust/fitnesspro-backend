<?php

namespace App\Api\Admin\OrderingRules\Controllers;

use App\Api\Admin\OrderingRules\Requests\OrderingRuleStatusRequest;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderingRuleStatusController extends AbstractController
{
    public function __invoke(OrderingRule $orderingRule, OrderingRuleStatusRequest $request)
    {
        $orderingRule->update(
            [
                'status' => $request->status,
            ]
        );
        return response(
            $orderingRule,
            Response::HTTP_CREATED
        );
    }
}
