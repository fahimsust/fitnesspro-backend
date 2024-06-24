<?php

namespace App\Api\Admin\OrderingRules\Controllers;

use App\Api\Admin\OrderingRules\Requests\OrderingRuleRequest;
use Domain\Products\Actions\OrderingRules\DeleteOrderingRule;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderingRuleController extends AbstractController
{
    public function index()
    {
        return response(
            OrderingRule::all(),
            Response::HTTP_OK
        );
    }
    public function store(OrderingRuleRequest $request)
    {
        return response(
            OrderingRule::Create([
                'name' => $request->name,
                'any_all' => $request->any_all,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function update(OrderingRule $orderingRule, OrderingRuleRequest $request)
    {
        $orderingRule->update([
            'name' => $request->name,
            'any_all' => $request->any_all,
        ]);
        return response(
            $orderingRule->refresh(),
            Response::HTTP_CREATED
        );
    }
    public function show(OrderingRule $orderingRule)
    {
        return response(
            $orderingRule,
            Response::HTTP_OK
        );
    }

    public function destroy(OrderingRule $orderingRule)
    {
        return response(
            DeleteOrderingRule::run($orderingRule),
            Response::HTTP_OK
        );
    }
}
