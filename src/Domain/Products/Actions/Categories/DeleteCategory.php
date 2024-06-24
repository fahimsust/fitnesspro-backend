<?php

namespace Domain\Products\Actions\Categories;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Product\ProductDetail;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteCategory
{
    use AsObject;

    public function handle(
        Category $category
    ): bool {
        if (ProductDetail::whereDefaultCategoryId($category->id)->count() > 0) {
            throw new \Exception(__('You have to update the category of :products to delete this category', [
                'products' => $category->products()
                    ->select('title')
                    ->take(5)
                    ->pluck('title')
                    ->implode(', '),
            ]));
        }
        $category->delete();
        return true;
    }
}
