<?php

namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\DiscountRuleRequest;
use App\Api\Admin\Discounts\Requests\DiscountRuleUpdateRequest;
use Domain\Discounts\Models\Rule\DiscountRule;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DiscountRuleController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            DiscountRule::whereDiscountId($request->discount_id)
                ->with([
                    'conditions',
                    'conditions.products',
                    'conditions.sites',
                    'conditions.countries',
                    'conditions.attributeOptions',
                    'conditions.attributeOptions.attribute',
                    'conditions.accountTypes',
                    'conditions.distributors',
                    'conditions.productTypes',
                    'conditions.onSaleStatuses',
                    'conditions.outOfStockStatuses',
                    'conditions.membershipLevels',
                    'conditions.productAvailabilities'
                ])
                ->get(),
            Response::HTTP_OK
        );
    }
    public function show(int $rule_id)
    {
        return response(
            DiscountRule::whereId($rule_id)
                ->with([
                    'conditions',
                    'conditions.products',
                    'conditions.sites',
                    'conditions.countries',
                    'conditions.attributeOptions',
                    'conditions.attributeOptions.attribute',
                    'conditions.accountTypes',
                    'conditions.distributors',
                    'conditions.productTypes',
                    'conditions.onSaleStatuses',
                    'conditions.outOfStockStatuses',
                    'conditions.membershipLevels',
                    'conditions.productAvailabilities'
                ])
                ->first(),
            Response::HTTP_OK
        );
    }
    public function store(DiscountRuleRequest $request)
    {
        return response(
            DiscountRule::create(
                [
                    'discount_id' => $request->discount_id,
                    'match_anyall' => 0
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function update(DiscountRule $discountRule, DiscountRuleUpdateRequest $request)
    {
        return response(
            $discountRule->update([
                'match_anyall' => $request->match_anyall,
                'rank' => $request->rank,
            ]),
            Response::HTTP_CREATED
        );
    }
    public function destroy(DiscountRule $discountRule)
    {
        return response(
            $discountRule->delete(),
            Response::HTTP_OK
        );
    }
}
