<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductImageRequest;
use App\Api\Admin\Products\Requests\UpdateProductImageRequest;
use Domain\Products\Actions\Product\AssignImageToProduct;
use Domain\Products\Actions\Product\DeleteProductImage;
use Domain\Products\Actions\Product\GetProductImage;
use Domain\Products\Actions\Product\UpdateProductImage;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductImageController extends AbstractController
{
    public function index(Product $product)
    {
        return response(
            $product->images,
            Response::HTTP_OK
        );
    }

    public function store(Product $product, ProductImageRequest $request)
    {
        return response(
            AssignImageToProduct::run($product, $request),
            Response::HTTP_CREATED
        );
    }

    public function update(Product $product, int $imageId, UpdateProductImageRequest $request)
    {
        return response(
            UpdateProductImage::run(
                GetProductImage::run($product, $imageId),
                $request
            ),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Product $product, int $imageId)
    {
        return response(
            DeleteProductImage::run($product, $imageId),
            Response::HTTP_OK
        );
    }
}
