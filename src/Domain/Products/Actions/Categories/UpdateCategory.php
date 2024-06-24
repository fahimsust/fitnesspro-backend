<?php

namespace Domain\Products\Actions\Categories;

use App\Api\Admin\Categories\Requests\CreateCategoryRequest;
use Domain\Products\Models\Category\Category;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateCategory
{
    use AsObject;

    public function handle(
        Category $category,
        CreateCategoryRequest $request
    ): Category {
        $category->update(
            [
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'url_name' => $request->url_name,
                'parent_id' => $request->parent_id,
                'description' => $request->description,
            ]
        );
        return $category->load('image');
    }
}
