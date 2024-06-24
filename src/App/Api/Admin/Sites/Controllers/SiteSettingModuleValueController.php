<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\SiteSettingModuleValueRequest;
use App\Api\Admin\Sites\Requests\SiteSettingModuleValueSearchRequest;
use Domain\Sites\Actions\GetSiteSettingModuleValues;
use Domain\Sites\Actions\UpdateSiteSettingModuleValue;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteSettingModuleValueController extends AbstractController
{
    public function index(SiteSettingModuleValueSearchRequest $request)
    {
        return response(
            GetSiteSettingModuleValues::run($request),
            Response::HTTP_OK
        );
    }
    public function store(SiteSettingModuleValueRequest $request)
    {
        return response(
            UpdateSiteSettingModuleValue::run($request),
            Response::HTTP_CREATED
        );
    }
}
