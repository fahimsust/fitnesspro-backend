<?php

namespace Domain\Products\Actions\Categories\ProductTypes;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Product\ProductType;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveProductTypeFromCategory
{
    use AsObject;

    public function handle(
        Category $category,
        int $typeId
    ): ProductType {
        if (! GetProductTypesAssignedToCategory::run($category, $typeId)) {
            throw new \Exception(__('Product type not assigned to category'));
        }

        $category->categoryProductTypes()->whereTypeId($typeId)->delete();

        return ProductType::find($typeId, ['name']);
    }
}
