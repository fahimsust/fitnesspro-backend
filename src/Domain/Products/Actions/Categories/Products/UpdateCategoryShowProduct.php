<?php

namespace Domain\Products\Actions\Categories\Products;

use App\Api\Admin\Categories\Requests\CategoryProductRankRequest;
use Domain\Products\Models\Category\Category;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateCategoryShowProduct
{
    use AsObject;

    public function handle(
        Category $category,
        int $productId,
        CategoryProductRankRequest $request
    ) {
        if (! IsProductSetToShowInCategory::run($category, $productId)) {
            throw new \Exception(__('Product not set to show in category'));
        }

        $category->categoryProductShows()->first()->whereProductId($productId)->update(
            [
                'rank'=>$request->rank
            ]
        );
        return $category->categoryProductShows;
    }
}
