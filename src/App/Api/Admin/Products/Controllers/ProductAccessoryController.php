<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductAccessoryRequest;
use Domain\Products\Actions\Product\CreateProductAccessory;
use Domain\Products\Actions\Product\GetProductAccessory;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessory;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductAccessoryController extends AbstractController
{
    public function index(Product $product)
    {
        return response(
            ProductAccessory::whereProductId($product->id)->with('accessory')->get(),
            Response::HTTP_OK
        );
    }
    public function store(Product $product, ProductAccessoryRequest $request)
    {
        return response(
            CreateProductAccessory::run($product, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Product $product, Product $accessory)
    {
        return response(
            GetProductAccessory::run($product, $accessory)->delete(),
            Response::HTTP_OK
        );
    }
}
