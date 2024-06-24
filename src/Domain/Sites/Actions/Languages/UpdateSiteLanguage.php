<?php

namespace Domain\Sites\Actions\Languages;

use App\Api\Admin\Sites\Requests\SiteLanguageRankRequest;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateSiteLanguage
{
    use AsObject;

    public function handle(
        Site                    $site,
        int                     $languageId,
        SiteLanguageRankRequest $request
    )
    {
        if (!IsLanguageActiveOnSite::run($site, $languageId)) {
            throw new \Exception(__('Language not active for this site'));
        }

        $site->siteLanguages()->whereLanguageId($languageId)->update([
            'rank' => $request->rank
        ]);
    }
}
