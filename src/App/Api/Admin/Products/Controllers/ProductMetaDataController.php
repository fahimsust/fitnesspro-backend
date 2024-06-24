<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductMetaDataRequest;
use Domain\Products\Actions\Product\UpdateProductMetaData;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductMetaDataController extends AbstractController
{
    public function index(Product $product)
    {
        return response(
            $product,
            Response::HTTP_OK
        );
    }

    public function store(Product $product, ProductMetaDataRequest $request)
    {
        return response(
            UpdateProductMetaData::run($product, $request),
            Response::HTTP_CREATED
        );
    }
}
