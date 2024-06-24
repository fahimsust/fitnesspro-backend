<?php

namespace Domain\Products\Actions\Categories\FeaturedProducts;

use App\Api\Admin\Categories\Requests\CategoryProductRequest;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryFeaturedProduct;
use Lorisleiva\Actions\Concerns\AsObject;

class FeatureProductInCategory
{
    use AsObject;

    public function handle(
        Category $category,
        CategoryProductRequest $request
    ): CategoryFeaturedProduct {
        if (IsProductFeaturedInCategory::run($category, $request->product_id)) {
            throw new \Exception(__('Product already featured in category'));
        }

        return $category->categoryFeaturedProducts()->create(
            [
                'product_id' => $request->product_id,
            ]
        );
    }
}
