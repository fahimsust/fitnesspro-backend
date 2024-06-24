<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\SiteLanguageRankRequest;
use App\Api\Admin\Sites\Requests\SiteLanguageRequest;
use Domain\Sites\Actions\Languages\ActivateLanguageForSite;
use Domain\Sites\Actions\Languages\DeactivateLanguageForSite;
use Domain\Sites\Actions\Languages\UpdateSiteLanguage;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteLanguageController extends AbstractController
{
    public function index(Site $site)
    {
        return response(
            $site->languages,
            Response::HTTP_OK
        );
    }
    public function store(Site $site, SiteLanguageRequest $request)
    {
        return response(
            ActivateLanguageForSite::run($site, $request),
            Response::HTTP_CREATED
        );
    }
    public function update(Site $site, int $languageId,SiteLanguageRankRequest $request )
    {
        return response(
            UpdateSiteLanguage::run($site, $languageId,$request),
            Response::HTTP_CREATED
        );
    }
    public function destroy(Site $site, int $languageId)
    {
        return response(
            DeactivateLanguageForSite::run($site, $languageId),
            Response::HTTP_OK
        );
    }
}
