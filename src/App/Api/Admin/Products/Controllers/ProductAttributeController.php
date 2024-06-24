<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductAttributeRequest;
use App\Api\Admin\Products\Requests\ProductIdRequest;
use Domain\Products\Actions\Product\GetProductTypeAttributesWithSelectedOption;
use Domain\Products\Actions\Product\UpdateAttributeOptionsAssignedToProduct;
use Domain\Products\Models\Product\ProductAttribute;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductAttributeController extends AbstractController
{
    public function index(ProductIdRequest $request)
    {
        return response(
            GetProductTypeAttributesWithSelectedOption::run($request),
            Response::HTTP_OK
        );
    }

    public function store(ProductAttributeRequest $request)
    {
        return response(
            UpdateAttributeOptionsAssignedToProduct::run($request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(ProductAttribute $productAttribute)
    {
        return response(
            $productAttribute->delete(),
            Response::HTTP_OK
        );
    }
}
