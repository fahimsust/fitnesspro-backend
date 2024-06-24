<?php

namespace Domain\Products\ValueObjects;

use App\Api\Products\Contracts\AbstractCategoryRequest;
use App\Api\Products\Requests\CategoryPageRequest;
use Domain\Products\Models\Category\Category;

class CategoryProductQueryParameters extends ProductQueryParameters
{
    public bool $featuredOnly = false;
    public bool $featuredShow = true;
    public bool $default = false;
    public bool $manuallyRelatedOnly = false;

    public static function fromCategoryPageRequest(
        Category                                    $category,
        CategoryPageRequest|AbstractCategoryRequest $request
    ): static
    {
        return static::from(
            [
//                'filters' => $category->filters,
                'featuredOnly' => $request->input('featured_only', 0),
                'featuredShow' => $category->calculatedSetting('show_featured'),
                'manuallyRelatedOnly' => $category->calculatedSetting('show_products')->useManual(),
            ] + static::standardFromRequest($request)
        );
    }
}
