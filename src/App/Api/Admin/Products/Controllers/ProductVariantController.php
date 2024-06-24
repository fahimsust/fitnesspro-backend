<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductSearchRequest;
use Domain\Products\Actions\ProductOptions\DeleteProductVariant;
use Domain\Products\Actions\ProductOptions\GetProductVariantInventory;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductVariantController extends AbstractController
{
    public function index(Product $product,ProductSearchRequest $request)
    {
        return response(
            GetProductVariantInventory::run($product,$request),
            Response::HTTP_OK
        );
    }
    public function destroy(Product $product, int $parentId)
    {
        return response(
            DeleteProductVariant::run($product, Product::findOrFail($parentId)),
            Response::HTTP_OK
        );
    }

}
