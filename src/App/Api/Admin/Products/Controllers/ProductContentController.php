<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductDetailsRequest;
use Domain\Products\Actions\Product\UpdateProductContent;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductContentController extends AbstractController
{
    public function __invoke(Product $product, ProductDetailsRequest $request)
    {
        return response(
            UpdateProductContent::run($product, $request),
            Response::HTTP_CREATED
        );
    }
}
