<?php

namespace App\Api\Admin\Categories\Controllers\Settings;

use App\Api\Admin\Categories\Requests\CategorySiteSettingModuleValueRequest;
use App\Api\Admin\Categories\Requests\CategorySiteSettingModuleValueSearchRequest;
use Domain\Products\Actions\Categories\Settings\GetCategorySiteSettingModuleValues;
use Domain\Products\Actions\Categories\Settings\UpdateCategorySiteSettingModuleValue;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategorySiteSettingModuleValueController extends AbstractController
{
    public function index(CategorySiteSettingModuleValueSearchRequest $request)
    {
        return response(
            GetCategorySiteSettingModuleValues::run($request),
            Response::HTTP_OK
        );
    }
    public function store(CategorySiteSettingModuleValueRequest $request)
    {
        return response(
            UpdateCategorySiteSettingModuleValue::run($request),
            Response::HTTP_CREATED
        );
    }
}
