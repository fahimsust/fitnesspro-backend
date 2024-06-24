<?php

namespace Domain\Sites\Actions\Languages;

use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;

class DeactivateLanguageForSite
{
    use AsObject;

    public function handle(
        Site $site,
        int  $languageId
    ): void
    {
        if (!IsLanguageActiveOnSite::run($site, $languageId)) {
            throw new \Exception(__('Language is not active yet'));
        }

        $site->siteLanguages()->whereLanguageId($languageId)->delete();
    }
}
