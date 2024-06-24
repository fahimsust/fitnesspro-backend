<?php

namespace Domain\Products\Actions\Categories\Products;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryProductShow;
use Lorisleiva\Actions\Concerns\AsObject;

class IsProductSetToShowInCategory
{
    use AsObject;

    public function handle(
        Category $category,
        int $productId,
    ): ?CategoryProductShow {
        return $category->categoryProductShows()->whereProductId($productId)->first();
    }
}
