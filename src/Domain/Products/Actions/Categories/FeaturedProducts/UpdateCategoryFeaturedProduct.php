<?php

namespace Domain\Products\Actions\Categories\FeaturedProducts;

use App\Api\Admin\Categories\Requests\CategoryProductRankRequest;
use Domain\Products\Models\Category\Category;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateCategoryFeaturedProduct
{
    use AsObject;

    public function handle(
        Category $category,
        int $productId,
        CategoryProductRankRequest $request
    ) {
        if (! IsProductFeaturedInCategory::run($category, $productId)) {
            throw new \Exception(__('Product not featured in category'));
        }

        $category->categoryFeaturedProducts()->whereProductId($productId)->update(
            [
                'rank'=>$request->rank
            ]
        );
        return $category->featuredProducts;
    }
}
