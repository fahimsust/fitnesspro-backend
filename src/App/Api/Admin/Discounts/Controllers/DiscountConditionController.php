<?php

namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\DiscountConditionRequest;
use App\Api\Admin\Discounts\Requests\DiscountConditionUpdateRequest;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DiscountConditionController extends AbstractController
{
    public function store(DiscountConditionRequest $request)
    {
        return response(
            DiscountCondition::create(
                [
                    'rule_id' => $request->rule_id,
                    'condition_type_id' => $request->condition_type_id,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function show(int $discount_id)
    {
        return response(
            DiscountCondition::whereId($discount_id)
                ->with([
                    'products',
                    'sites',
                    'countries',
                    'attributeOptions',
                    'attributeOptions.attribute',
                    'accountTypes',
                    'distributors',
                    'productTypes',
                    'membershipLevels',
                    'onSaleStatuses',
                    'outOfStockStatuses',
                    'productAvailabilities'
                ])
                ->first(),
            Response::HTTP_OK
        );
    }
    public function update(DiscountCondition $discountRuleCondition, DiscountConditionUpdateRequest $request)
    {
        $data = $request->validated();
        return response(
            $discountRuleCondition->update($data),
            Response::HTTP_CREATED
        );
    }
    public function destroy(DiscountCondition $discountRuleCondition)
    {
        return response(
            $discountRuleCondition->delete(),
            Response::HTTP_OK
        );
    }
}
