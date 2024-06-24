<?php

namespace Domain\Sites\Actions\Categories;

use App\Api\Admin\Sites\Requests\SiteCategoryRequest;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class AddCategoryToSite
{
    use AsObject;

    public function handle(
        Site $site,
        SiteCategoryRequest $request
    ): Collection {
        if (IsCategoryAssignedToSite::run($site, $request->category_id)) {
            throw new \Exception(__('Category already exists in site'));
        }

        $site->siteCategories()->create(
            [
                'category_id' => $request->category_id,
            ]
        );

        return $site->siteCategories;
    }
}
