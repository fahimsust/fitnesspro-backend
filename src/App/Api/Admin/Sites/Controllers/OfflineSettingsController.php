<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\UpdateOfflineSettingsRequest;
use Domain\Sites\Actions\Offline\UpdateOfflineSettings;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OfflineSettingsController extends AbstractController
{
    public function index(Site $site)
    {
        return response(
            [
                'offline_message' => $site->offline_message,
                'offline_layout_id' => $site->settings->offline_layout_id,
            ],
            Response::HTTP_OK
        );
    }

    public function store(Site $site, UpdateOfflineSettingsRequest $request)
    {
        return response(
            UpdateOfflineSettings::run($site, $request),
            Response::HTTP_CREATED
        );
    }
}
