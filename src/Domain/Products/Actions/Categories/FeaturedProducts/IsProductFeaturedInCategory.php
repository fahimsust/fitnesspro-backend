<?php

namespace Domain\Products\Actions\Categories\FeaturedProducts;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryFeaturedProduct;
use Lorisleiva\Actions\Concerns\AsObject;

class IsProductFeaturedInCategory
{
    use AsObject;

    public function handle(
        Category $category,
        int $productId,
    ): ?CategoryFeaturedProduct {
        return $category->categoryFeaturedProducts()->whereProductId($productId)->first();
    }
}
