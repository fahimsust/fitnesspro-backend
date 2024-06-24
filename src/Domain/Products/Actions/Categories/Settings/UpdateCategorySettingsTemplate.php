<?php

namespace Domain\Products\Actions\Categories\Settings;

use App\Api\Admin\Categories\Requests\CategorySettingsRequest;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategorySettings;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateCategorySettingsTemplate
{
    use AsObject;

    public function handle(
        Category $category,
        CategorySettingsRequest $request
    ): CategorySettings {
        $category->settings()->updateOrCreate(
            [],
            [
                'settings_template_id' => $request->settings_template_id,
            ]
        );

        return $category->refresh()->settings;
    }
}
