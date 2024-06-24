<?php

namespace Domain\Content\Actions;

use Domain\Content\Models\Pages\Page;
use Lorisleiva\Actions\Concerns\AsObject;

class DeletePage
{
    use AsObject;

    public function handle(
        Page $page
    ): bool {
        $page->defaultSettings()->delete();
        $page->pagesCategories()->delete();
        $page->sitePageSettings()->delete();
        $page->sitePageSettingsModuleValue()->delete();
        $page->menusPages()->delete();
        $page->delete();
        return true;
    }
}
