<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductSiteSettingModuleValueRequest;
use App\Api\Admin\Products\Requests\ProductSiteSettingModuleValueSearchRequest;
use Domain\Products\Actions\GetProductSiteSettingModuleValues;
use Domain\Products\Actions\UpdateProductSiteSettingModuleValue;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductSiteSettingModuleValueController extends AbstractController
{
    public function index(ProductSiteSettingModuleValueSearchRequest $request)
    {
        return response(
            GetProductSiteSettingModuleValues::run($request),
            Response::HTTP_OK
        );
    }
    public function store(ProductSiteSettingModuleValueRequest $request)
    {
        return response(
            UpdateProductSiteSettingModuleValue::run($request),
            Response::HTTP_CREATED
        );
    }
}
