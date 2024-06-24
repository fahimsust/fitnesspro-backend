<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductSiteStatusRequest;
use Domain\Products\Actions\Pricing\GetProductPricing;
use Domain\Products\Actions\Pricing\UpdateProductSiteStatus;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductSiteStatusController extends AbstractController
{
    public function __invoke(Product $product, ProductSiteStatusRequest $request)
    {
        return response(
            UpdateProductSiteStatus::run(
                GetProductPricing::run($product, $request->site_id),
                $request->status
            ),
            Response::HTTP_CREATED
        );
    }
}
