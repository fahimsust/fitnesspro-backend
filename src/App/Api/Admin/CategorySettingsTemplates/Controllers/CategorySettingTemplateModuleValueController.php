<?php

namespace App\Api\Admin\CategorySettingsTemplates\Controllers;

use App\Api\Admin\CategorySettingsTemplates\Requests\CategoryTemplateSettingModuleValueRequest;
use App\Api\Admin\CategorySettingsTemplates\Requests\SettingModuleValueSearchRequest;
use Domain\Products\Actions\Categories\Settings\GetCategorySettingTemplateModuleValues;
use Domain\Products\Actions\Categories\Settings\UpdateCategorySettingTemplateModuleValue;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategorySettingTemplateModuleValueController extends AbstractController
{
    public function index(SettingModuleValueSearchRequest $request)
    {
        return response(
            GetCategorySettingTemplateModuleValues::run($request),
            Response::HTTP_OK
        );
    }
    public function store(CategoryTemplateSettingModuleValueRequest $request)
    {
        return response(
            UpdateCategorySettingTemplateModuleValue::run($request),
            Response::HTTP_CREATED
        );
    }
}
