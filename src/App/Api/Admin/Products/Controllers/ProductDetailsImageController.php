<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductDetailsImageRequest;
use Domain\Products\Actions\Product\SetProductDetailsImage;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductDetailsImageController extends AbstractController
{
    public function __invoke(Product $product, ProductDetailsImageRequest $request)
    {
        return response(
            SetProductDetailsImage::run($product, $request),
            Response::HTTP_CREATED
        );
    }
}
