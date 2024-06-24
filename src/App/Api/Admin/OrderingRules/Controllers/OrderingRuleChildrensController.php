<?php

namespace App\Api\Admin\OrderingRules\Controllers;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderingRuleChildrensController extends AbstractController
{
    public function __invoke(OrderingRule $orderingRule)
    {
        return response(
            $orderingRule->childRules,
            Response::HTTP_OK
        );
    }
}
