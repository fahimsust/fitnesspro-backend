<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\SiteCurrencyRankRequest;
use App\Api\Admin\Sites\Requests\SiteCurrencyRequest;
use Domain\Sites\Actions\Currencies\ActivateCurrencyForSite;
use Domain\Sites\Actions\Currencies\DeactivateCurrencyForSite;
use Domain\Sites\Actions\Currencies\UpdateSiteCurrency;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteCurrencyController extends AbstractController
{
    public function index(Site $site)
    {
        return response(
            $site->currencies,
            Response::HTTP_OK
        );
    }
    public function store(Site $site, SiteCurrencyRequest $request)
    {
        return response(
            ActivateCurrencyForSite::run($site, $request),
            Response::HTTP_CREATED
        );
    }
    public function update(Site $site, int $currencyId,SiteCurrencyRankRequest $request )
    {
        return response(
            UpdateSiteCurrency::run($site, $currencyId,$request),
            Response::HTTP_CREATED
        );
    }
    public function destroy(Site $site, int $currencyId)
    {
        return response(
            DeactivateCurrencyForSite::run($site, $currencyId),
            Response::HTTP_OK
        );
    }
}
