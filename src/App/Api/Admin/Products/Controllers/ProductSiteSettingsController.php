<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductSiteSettingsRequest;
use Domain\Products\Actions\Product\GetSiteSettingsForProduct;
use Domain\Products\Actions\Product\UpdateProductSiteSettings;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductSiteSettingsController extends AbstractController
{
    public function index(Product $product)
    {
        return response(
            GetSiteSettingsForProduct::run($product),
            Response::HTTP_OK
        );
    }
    public function store(Product $product, ProductSiteSettingsRequest $request)
    {
        return response(
            UpdateProductSiteSettings::run($product, $request),
            Response::HTTP_CREATED
        );
    }
}
