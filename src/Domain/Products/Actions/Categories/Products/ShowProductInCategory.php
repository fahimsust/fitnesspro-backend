<?php

namespace Domain\Products\Actions\Categories\Products;

use App\Api\Admin\Categories\Requests\CategoryProductRequest;
use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class ShowProductInCategory
{
    use AsObject;

    public function handle(
        Category $category,
        CategoryProductRequest $request
    ): Collection {
        if (IsProductSetToShowInCategory::run($category, $request->product_id)) {
            throw new \Exception(__('Product already set to show in category'));
        }

        $category->categoryProductShows()->create(
            [
                'product_id' => $request->product_id,
                'manual' => 1,
            ]
        );

        return $category->categoryProductShows;
    }
}
