<?php

namespace Domain\Products\Actions\Categories\Brands;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryBrand;
use Lorisleiva\Actions\Concerns\AsObject;

class GetBrandsAssignedToCategory
{
    use AsObject;

    public function handle(
        Category $category,
        int $brand_id,
    ): ?CategoryBrand {
        return $category->categoryBrands()->whereBrandId($brand_id)->first();
    }
}
