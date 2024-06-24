<?php

namespace Domain\Products\Actions\Categories\Settings;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategorySiteSettings;
use Lorisleiva\Actions\Concerns\AsObject;

class GetCategorySiteSettings
{
    use AsObject;

    public function handle(
        Category $category,
        ?int $site_id,
    ): ?CategorySiteSettings {
        return $category->siteSettings()->whereSiteId($site_id)->first();
    }
}
