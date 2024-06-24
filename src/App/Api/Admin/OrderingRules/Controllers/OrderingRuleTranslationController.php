<?php

namespace App\Api\Admin\OrderingRules\Controllers;

use App\Api\Admin\OrderingRules\Requests\OrderingRuleTranslationRequest;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\OrderingRules\OrderingRuleTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderingRuleTranslationController extends AbstractController
{
    public function update(OrderingRule $orderingRule,int $language_id, OrderingRuleTranslationRequest $request)
    {
        return response(
            $orderingRule->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'name' => $request->name,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $rule_id,int $language_id)
    {
        return response(
            OrderingRuleTranslation::where('rule_id',$rule_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
