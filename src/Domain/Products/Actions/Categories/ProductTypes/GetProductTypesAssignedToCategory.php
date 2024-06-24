<?php

namespace Domain\Products\Actions\Categories\ProductTypes;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryProductType;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductTypesAssignedToCategory
{
    use AsObject;

    public function handle(
        Category $category,
        int $type_id,
    ): ?CategoryProductType {
        return $category->categoryProductTypes()->whereTypeId($type_id)->first();
    }
}
