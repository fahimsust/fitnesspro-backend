<?php

namespace App\Api\Admin\ProductSettingsTemplates\Controllers;

use App\Api\Admin\ProductSettingsTemplates\Requests\ProductSettingsTemplateRequest;
use Domain\Products\Actions\Product\CreateProductSettingTemplate;
use Domain\Products\Actions\Product\ModifyProductSettingTemplate;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplate;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductSettingsTemplateController extends AbstractController
{
    public function index()
    {
        return Response(
            ProductSettingsTemplate::all(),
            Response::HTTP_OK
        );
    }
    public function store(ProductSettingsTemplateRequest $request)
    {
        return response(
            CreateProductSettingTemplate::run($request),
            Response::HTTP_CREATED
        );
    }
    public function update(ProductSettingsTemplate $productSettingsTemplate,ProductSettingsTemplateRequest $request)
    {
        return response(
            ModifyProductSettingTemplate::run($productSettingsTemplate,$request),
            Response::HTTP_CREATED
        );
    }
    public function show(ProductSettingsTemplate $productSettingsTemplate)
    {
        return response(
            $productSettingsTemplate,
            Response::HTTP_CREATED
        );
    }
    public function destroy(ProductSettingsTemplate $productSettingsTemplate)
    {
        return response(
            $productSettingsTemplate->delete(),
            Response::HTTP_OK
        );
    }
}
