<?php

namespace App\Api\Admin\Categories\Controllers\Rules;

use App\Api\Admin\Categories\Requests\CategoryCondtionRuleRequest;
use Domain\Products\Actions\Categories\Rules\AddAttributeValueConditionToCategoryRule;
use Domain\Products\Actions\Categories\Rules\RemoveAttributeValueConditionFromCategoryRule;
use Domain\Products\Models\Category\Rule\CategoryRule;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryRuleConditionController extends AbstractController
{
    public function index(CategoryRule $categoryRule)
    {
        return response(
            $categoryRule->categoryRuleAttributes->each->load('attributeOption.Attribute'),
            Response::HTTP_OK
        );
    }

    public function store(CategoryRule $categoryRule, CategoryCondtionRuleRequest $request)
    {
        return response(
            AddAttributeValueConditionToCategoryRule::now(
                rule: $categoryRule,
                value_id: $request->value_id,
                set_id: $request->set_id,
                matches: $request->matches
            ),
            Response::HTTP_CREATED
        );
    }

    public function destroy(
        CategoryRule $categoryRule,
        int          $categoryRuleConditionId
    )
    {
        return response(
            RemoveAttributeValueConditionFromCategoryRule::now(
                $categoryRule,
                $categoryRuleConditionId
            ),
            Response::HTTP_OK
        );
    }
}
