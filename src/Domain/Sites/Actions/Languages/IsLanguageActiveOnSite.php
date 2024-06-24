<?php

namespace Domain\Sites\Actions\Languages;

use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteLanguage;
use Lorisleiva\Actions\Concerns\AsObject;

class IsLanguageActiveOnSite
{
    use AsObject;

    public function handle(
        Site $site,
        int $languageId,
    ): ?SiteLanguage {
        return $site->siteLanguages()->whereLanguageId($languageId)->first();
    }
}
