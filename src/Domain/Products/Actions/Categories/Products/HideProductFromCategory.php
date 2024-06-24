<?php

namespace Domain\Products\Actions\Categories\Products;

use App\Api\Admin\Categories\Requests\CategoryProductRequest;
use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class HideProductFromCategory
{
    use AsObject;

    public function handle(
        Category $category,
        CategoryProductRequest $request
    ): Collection {
        if (IsProductSetToHideFromCategory::run($category, $request->product_id)) {
            throw new \Exception(__('Product already hidden from category'));
        }

        $category->categoryProductHides()->create(
            [
                'product_id' => $request->product_id,
            ]
        );

        return $category->categoryProductHides;
    }
}
