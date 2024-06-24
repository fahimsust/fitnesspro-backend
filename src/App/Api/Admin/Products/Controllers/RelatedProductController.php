<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\RelatedProductRequest;
use Domain\Products\Actions\Product\CreateRelatedProduct;
use Domain\Products\Actions\Product\GetRelatedProduct;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RelatedProductController extends AbstractController
{
    public function index(Product $product)
    {
        return response(
            $product->relatedProducts,
            Response::HTTP_OK
        );
    }

    public function store(Product $product, RelatedProductRequest $request)
    {
        return response(
            CreateRelatedProduct::run($product, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Product $product, Product $related)
    {
        return response(
            GetRelatedProduct::run($product, $related)->delete(),
            Response::HTTP_OK
        );
    }
}
