<?php

namespace Domain\Products\Actions\Categories\Products;

use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class StopHidingProductFromCategory
{
    use AsObject;

    public function handle(
        Category $category,
        int $productId
    ): Collection {
        if (! IsProductSetToHideFromCategory::run($category, $productId)) {
            throw new \Exception(__('Product not set to hide from category'));
        }

        $category->categoryProductHides()->whereProductId($productId)->delete();

        return $category->productsToHide;
    }
}
