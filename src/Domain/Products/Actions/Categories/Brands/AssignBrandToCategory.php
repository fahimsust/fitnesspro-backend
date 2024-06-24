<?php

namespace Domain\Products\Actions\Categories\Brands;

use App\Api\Admin\Categories\Requests\CategoryBrandRequest;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryBrand;
use Lorisleiva\Actions\Concerns\AsObject;

class AssignBrandToCategory
{
    use AsObject;

    public function handle(
        Category $category,
        CategoryBrandRequest $request
    ): CategoryBrand {
        if (GetBrandsAssignedToCategory::run($category, $request->brand_id)) {
            throw new \Exception(__('Brand already assigned to category'));
        }

        return $category->categoryBrands()->create(
            [
                'brand_id' => $request->brand_id,
            ]
        );
    }
}
