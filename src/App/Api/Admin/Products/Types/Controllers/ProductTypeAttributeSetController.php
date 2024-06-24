<?php

namespace App\Api\Admin\Products\Types\Controllers;

use App\Api\Admin\Products\Types\Requests\ProductTypeAttributeSetRequest;
use Domain\Products\Actions\Types\AssignAttributeSetToProductType;
use Domain\Products\Actions\Types\RemoveAttributeSetFromProductType;
use Domain\Products\Models\Product\ProductType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductTypeAttributeSetController extends AbstractController
{
    public function index(ProductType $productType)
    {
        return response(
            $productType->attributeSets,
            Response::HTTP_OK
        );
    }

    public function store(ProductType $productType, ProductTypeAttributeSetRequest $request)
    {
        return response(
            AssignAttributeSetToProductType::run($productType, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(ProductType $productType, int $setId)
    {
        return response(
            RemoveAttributeSetFromProductType::run($productType, $setId),
            Response::HTTP_OK
        );
    }
}
