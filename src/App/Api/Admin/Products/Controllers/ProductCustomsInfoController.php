<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductCustomsInfoRequest;
use Domain\Products\Actions\Product\UpdateProductCustomsInfo;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductCustomsInfoController extends AbstractController
{
    public function index(Product $product)
    {
        return response(
            $product,
            Response::HTTP_OK
        );
    }

    public function store(Product $product, ProductCustomsInfoRequest $request)
    {
        return response(
            UpdateProductCustomsInfo::run($product, $request),
            Response::HTTP_CREATED
        );
    }
}
