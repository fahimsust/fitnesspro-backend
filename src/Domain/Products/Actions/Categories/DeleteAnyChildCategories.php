<?php

namespace Domain\Products\Actions\Categories;

use Domain\Products\Models\Category\Category;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteAnyChildCategories
{
    use AsObject;

    public function handle(
        Category $category
    ): bool {
        foreach ($category->subcategories as $subcategory) {
            DeleteCategory::run($subcategory);
        }
        return true;
    }
}
