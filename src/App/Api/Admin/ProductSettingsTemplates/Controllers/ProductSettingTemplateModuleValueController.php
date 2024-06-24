<?php

namespace App\Api\Admin\ProductSettingsTemplates\Controllers;

use App\Api\Admin\ProductSettingsTemplates\Requests\ProductTemplateSettingModuleValueRequest;
use App\Api\Admin\ProductSettingsTemplates\Requests\ProductTemplateSettingModuleValueSearchRequest;
use Domain\Products\Actions\Product\GetProductSettingTemplateModuleValues;
use Domain\Products\Actions\Product\UpdateProductSettingTemplateModuleValue;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductSettingTemplateModuleValueController extends AbstractController
{
    public function index(ProductTemplateSettingModuleValueSearchRequest $request)
    {
        return response(
            GetProductSettingTemplateModuleValues::run($request),
            Response::HTTP_OK
        );
    }
    public function store(ProductTemplateSettingModuleValueRequest $request)
    {
        return response(
            UpdateProductSettingTemplateModuleValue::run($request),
            Response::HTTP_CREATED
        );
    }
}
