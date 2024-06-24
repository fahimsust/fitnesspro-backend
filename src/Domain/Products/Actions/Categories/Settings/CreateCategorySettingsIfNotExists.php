<?php

namespace Domain\Products\Actions\Categories\Settings;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategorySettings;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateCategorySettingsIfNotExists
{
    use AsObject;

    public function handle(
        Category $category,
    ): CategorySettings {
        if (empty($category->settings)) {
            $category->settings()->create();
        }
        return $category->refresh()->settings;
    }
}
