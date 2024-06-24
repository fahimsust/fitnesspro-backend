<?php

namespace Domain\Products\Actions\Categories;

use App\Api\Admin\Categories\Requests\CreateCategoryRequest;
use Domain\Products\Actions\Categories\Settings\CreateCategorySiteSettings;
use Domain\Products\Models\Category\Category;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateCategory
{
    use AsObject;

    public function handle(
        CreateCategoryRequest $request
    ): Category {
        $category = Category::create(
            [
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'url_name' => $request->url_name,
                'parent_id' => $request->parent_id,
                'description' => $request->description,
            ]
        );
        CreateCategorySiteSettings::run($category);
        return $category;
    }
}
