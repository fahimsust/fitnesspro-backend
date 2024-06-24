<?php

namespace Domain\Products\Actions\Categories\Products;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryProductHide;
use Lorisleiva\Actions\Concerns\AsObject;

class IsProductSetToHideFromCategory
{
    use AsObject;

    public function handle(
        Category $category,
        int $product_id,
    ): ?CategoryProductHide {
        return $category->categoryProductHides()->whereProductId($product_id)->first();
    }
}
