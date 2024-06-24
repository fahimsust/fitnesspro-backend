<?php

namespace Domain\Sites\Actions\Categories;

use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveCategoryFromSite
{
    use AsObject;

    public function handle(
        Site $site,
        int $category_id
    ): Collection {
        if (! IsCategoryAssignedToSite::run($site, $category_id)) {
            throw new \Exception(__('Category is not assigned to site'));
        }

        $site->siteCategories()->whereCategoryId($category_id)->delete();

        return $site->siteCategories()->get();
    }
}
