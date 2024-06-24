<?php

namespace Domain\Products\Actions\Categories\Settings;

use App\Api\Admin\Categories\Requests\CategoryFilterSettingsRequest;
use Domain\Products\Models\Category\Category;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateCategoryFilterSettings
{
    use AsObject;

    public function handle(
        Category $category,
        CategoryFilterSettingsRequest $request
    ): Category {
        $category->update(
            [
                'rules_match_type' => $request->rules_match_type,
                'show_types' => $request->show_types,
                'show_brands' => $request->show_brands,
                'limit_min_price' => $request->limit_min_price,
                'min_price' => $request->min_price,
                'limit_max_price' => $request->limit_max_price,
                'max_price' => $request->max_price,
                'limit_days' => $request->limit_days,
                'show_sale' => $request->show_sale,
            ]
        );
        return $category->load('image');
    }
}
