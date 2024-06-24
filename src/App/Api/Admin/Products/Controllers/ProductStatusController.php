<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductStatusRequest;
use Domain\Products\Actions\Product\UpdateProductStatus;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductStatusController extends AbstractController
{
    public function __invoke(Product $product, ProductStatusRequest $request)
    {
        return response(
            UpdateProductStatus::run($product, $request),
            Response::HTTP_CREATED
        );
    }
}
