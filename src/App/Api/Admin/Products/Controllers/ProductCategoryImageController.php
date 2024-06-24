<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductCategoryImageRequest;
use Domain\Products\Actions\Product\SetProductCategoryImage;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductCategoryImageController extends AbstractController
{
    public function __invoke(Product $product, ProductCategoryImageRequest $request)
    {
        return response(
            SetProductCategoryImage::run($product, $request),
            Response::HTTP_CREATED
        );
    }
}
