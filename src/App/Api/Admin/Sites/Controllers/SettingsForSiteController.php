<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\SettingsForSiteRequest;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SettingsForSiteController extends AbstractController
{
    public function index(Site $site)
    {
        return response(
            $site->settings,
            Response::HTTP_OK
        );
    }

    public function store(Site $site, SettingsForSiteRequest $request)
    {
        SiteSettings::updateOrCreate(
            [
                'site_id'=>$site->id
            ],
            [
                'home_show_categories_in_body' => $request->home_show_categories_in_body,
                'home_feature_show' => $request->home_feature_show,
                'catalog_show_categories_in_body' => $request->catalog_show_categories_in_body,
                'catalog_feature_show' => $request->catalog_feature_show,
                'default_show_categories_in_body' => $request->default_show_categories_in_body,
            ]
        );

        return response(
            $site->settings,
            Response::HTTP_CREATED
        );
    }
}
