<?php

namespace App\Api\Admin\Products\Types\Controllers;

use App\Api\Admin\Products\Types\Requests\ProductTypeRequest;
use Domain\Products\Actions\Types\CreateProductType;
use Domain\Products\Actions\Types\DeleteProductType;
use Domain\Products\Actions\Types\UpdateProductType;
use Domain\Products\Models\Product\ProductType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductTypeController extends AbstractController
{
    public function index()
    {
        return response(
            ProductType::orderBy('name')->get(),
            Response::HTTP_OK
        );
    }

    public function store(ProductTypeRequest $request)
    {
        $productType = CreateProductType::run($request);
        return response(
            [
                'id'=>$productType->id,
                'name'=>$productType->name,
                'attribute_sets'=>$productType->attributeSets,
                'selectedAttributeSet' => $productType->attributeSets->pluck('id')->toArray(),
                'selectedTaxRules' => $productType->taxRules->pluck('id')->toArray()
            ],
            Response::HTTP_CREATED
        );
    }

    public function update(ProductType $productType, ProductTypeRequest $request)
    {
        return response(
            UpdateProductType::run($productType, $request),
            Response::HTTP_CREATED
        );
    }

    public function show(ProductType $productType)
    {
        return response(
            $productType->load('attributeSets','taxRules'),
            Response::HTTP_OK
        );
    }

    public function destroy(ProductType $productType)
    {
        return response(
            DeleteProductType::run($productType),
            Response::HTTP_OK
        );
    }
}
