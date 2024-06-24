<?php

namespace Domain\Products\Actions\Categories\FeaturedProducts;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class StopFeaturingProductInCategory
{
    use AsObject;

    public function handle(
        Category $category,
        int $productId
    ): Product {
        if (! IsProductFeaturedInCategory::run($category, $productId)) {
            throw new \Exception(__('Product not featured in category'));
        }

        $category->categoryFeaturedProducts()->whereProductId($productId)->delete();

        return Product::find($productId, ['title']);
    }
}
