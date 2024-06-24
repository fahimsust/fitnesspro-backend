<?php

namespace Domain\Products\Actions\Categories\Brands;

use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveBrandFromCategory
{
    use AsObject;

    public function handle(
        Category $category,
        int $brandId
    ): Brand {
        if (! GetBrandsAssignedToCategory::run($category, $brandId)) {
            throw new \Exception(__('Brand not assigned to category'));
        }

        $category->categoryBrands()->whereBrandId($brandId)->delete();

        return Brand::find($brandId, ['name']);
    }
}
