<?php

namespace Domain\Products\Actions\Categories;

use App\Api\Admin\Categories\Requests\CategoryMetaDataRequest;
use Domain\Products\Models\Category\Category;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateCategoryMetaData
{
    use AsObject;

    public function handle(
        Category $category,
        CategoryMetaDataRequest $request
    ): Category {
        $category->update(
            [
                'meta_title' => $request->meta_title,
                'meta_desc' => $request->meta_desc,
                'meta_keywords' => $request->meta_keywords,
            ]
        );
        return $category->load('image');
    }
}
