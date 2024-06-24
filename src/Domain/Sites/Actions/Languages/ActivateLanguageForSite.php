<?php

namespace Domain\Sites\Actions\Languages;

use App\Api\Admin\Sites\Requests\SiteLanguageRequest;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteLanguage;
use Lorisleiva\Actions\Concerns\AsObject;

class ActivateLanguageForSite
{
    use AsObject;

    public function handle(
        Site                $site,
        SiteLanguageRequest $request
    ): SiteLanguage
    {
        if (IsLanguageActiveOnSite::run($site, $request->language_id)) {
            throw new \Exception(__('Language Already Active on Site'));
        }

        return $site->siteLanguages()->create([
            'language_id' => $request->language_id,
        ]);
    }
}
