<?php

namespace Domain\Products\Actions\Categories\Settings;

use App\Api\Admin\Categories\Requests\CategoryMenuSettingsRequest;
use Domain\Products\Models\Category\Category;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateCategoryMenuSettings
{
    use AsObject;

    public function handle(
        Category $category,
        CategoryMenuSettingsRequest $request
    ): Category {
        $category->update(
            [
                'rank' => $request->rank,
                'show_in_list' => $request->show_in_list,
                'menu_class' => $request->menu_class,
            ]
        );
        return $category->load('image');
    }
}
