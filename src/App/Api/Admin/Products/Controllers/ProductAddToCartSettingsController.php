<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductAddToCartSettingsRequest;
use Domain\Products\Actions\Product\UpdateProductAddToCartSettings;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductAddToCartSettingsController extends AbstractController
{
    public function index(Product $product)
    {
        return response(
            $product,
            Response::HTTP_OK
        );
    }

    public function store(Product $product, ProductAddToCartSettingsRequest $request)
    {
        return response(
            UpdateProductAddToCartSettings::run($product, $request),
            Response::HTTP_CREATED
        );
    }
}
