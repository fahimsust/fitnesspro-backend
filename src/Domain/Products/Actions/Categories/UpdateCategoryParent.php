<?php

namespace Domain\Products\Actions\Categories;

use Domain\Products\Models\Category\Category;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateCategoryParent
{
    use AsObject;

    public function handle(
        Category $category,
        int $parentCategoryId
    ): Category {
        $category->update([
            'parent_id' => $parentCategoryId,
        ]);

        return $category;
    }
}
