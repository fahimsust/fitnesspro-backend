<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\UpdateProductDetailsRequest;
use Domain\Products\Actions\Product\UpdateProductDetails;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductDetailsController extends AbstractController
{
    public function __invoke(Product $product, UpdateProductDetailsRequest $request)
    {
        return response(
            UpdateProductDetails::run($product, $request),
            Response::HTTP_CREATED
        );
    }
}
