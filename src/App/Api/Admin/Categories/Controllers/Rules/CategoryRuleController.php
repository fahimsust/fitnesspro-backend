<?php

namespace App\Api\Admin\Categories\Controllers\Rules;

use App\Api\Admin\Categories\Requests\CategoryRuleRequest;
use Domain\Products\Actions\Categories\Rules\CreateCategoryRule;
use Domain\Products\Actions\Categories\Rules\DeleteCategoryRule;
use Domain\Products\Actions\Categories\Rules\UpdateCategoryRuleMatchType;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Support\Enums\MatchAllAnyString;
use Symfony\Component\HttpFoundation\Response;

class CategoryRuleController extends AbstractController
{
    public function index(Category $category)
    {
        return response(
            $category->rules()
                ->with('categoryRuleAttributes.attributeOption.Attribute')
                ->get(),
            Response::HTTP_OK
        );
    }

    public function store(Category $category, CategoryRuleRequest $request)
    {
        return response(
            CreateCategoryRule::now(
                $category,
                MatchAllAnyString::from($request->match_type)
            ),
            Response::HTTP_CREATED
        );
    }

    public function update(
        Category            $category,
        int                 $ruleId,
        CategoryRuleRequest $request
    )
    {
        return response(
            UpdateCategoryRuleMatchType::now(
                $category->rules()->select("id")->findOrFail($ruleId),
                MatchAllAnyString::from($request->match_type)
            ),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Category $category, int $ruleId)
    {
        return response(
            DeleteCategoryRule::now(
                $category->rules()->select("id")->findOrFail($ruleId)
            ),
            Response::HTTP_OK
        );
    }
}
