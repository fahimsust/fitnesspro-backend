<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductAccessoryFieldRequest;
use Domain\Products\Actions\Product\CreateProductAccessoryField;
use Domain\Products\Actions\Product\GetProductAccessoryField;
use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessoryField;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductAccessoryFieldController extends AbstractController
{
    public function index(Product $product)
    {
        return response(
            ProductAccessoryField::whereProductId($product->id)->orderBy('products_accessories_fields.rank')->with('accessoryField')->get(),
            Response::HTTP_OK
        );
    }
    public function store(Product $product, ProductAccessoryFieldRequest $request)
    {
        return response(
            CreateProductAccessoryField::run($product, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Product $product, AccessoryField $accessoryField)
    {
        return response(
            GetProductAccessoryField::run($product, $accessoryField)->delete(),
            Response::HTTP_OK
        );
    }
}
