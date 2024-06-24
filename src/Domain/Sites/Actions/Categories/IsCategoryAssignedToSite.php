<?php

namespace Domain\Sites\Actions\Categories;

use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteCategory;
use Lorisleiva\Actions\Concerns\AsObject;

class IsCategoryAssignedToSite
{
    use AsObject;

    public function handle(
        Site $site,
        int $category_id
    ): ?SiteCategory {
        return $site->siteCategories()->whereCategoryId($category_id)->first();
    }
}
