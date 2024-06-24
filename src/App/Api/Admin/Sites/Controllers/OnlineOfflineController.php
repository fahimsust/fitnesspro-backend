<?php

namespace App\Api\Admin\Sites\Controllers;

use Domain\Sites\Actions\Offline\TakeSiteOffline;
use Domain\Sites\Actions\Offline\TakeSiteOnline;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OnlineOfflineController extends AbstractController
{
    public function store(Site $site)
    {
        return response(
            TakeSiteOnline::run($site),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Site $site)
    {
        return response(
            TakeSiteOffline::run($site),
            Response::HTTP_OK
        );
    }
}
