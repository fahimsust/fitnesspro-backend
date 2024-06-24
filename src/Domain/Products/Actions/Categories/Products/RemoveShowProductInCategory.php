<?php

namespace Domain\Products\Actions\Categories\Products;

use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveShowProductInCategory
{
    use AsObject;

    public function handle(
        Category $category,
        int $productId
    ): Collection {
        if (! IsProductSetToShowInCategory::run($category, $productId)) {
            throw new \Exception(__('Product not set to show in category'));
        }

        $category->categoryProductShows()->whereProductId($productId)->delete();

        return $category->categoryProductShows()->get();
    }
}
