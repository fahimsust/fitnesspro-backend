<?php

namespace Domain\Products\Actions\Categories\Settings;

use Domain\Products\Models\Category\Category;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateCategorySiteSettings
{
    use AsObject;

    public function handle(
        Category $category
    ) {
        $rows = Site::all()->map(
            fn (Site $site) => ['site_id' => $site->id]
        )->toArray();

        $rows[] = ['site_id' => null];
        $category->siteSettings()->createMany($rows);
    }
}
