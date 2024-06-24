<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductSitePricingRuleRequest;
use Domain\Products\Actions\Pricing\GetProductPricing;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductSitePricingRuleController extends AbstractController
{
    public function __invoke(Product $product, ProductSitePricingRuleRequest $request)
    {
        $productPricing = GetProductPricing::run($product, $request->site_id);
        $productPricing->update(
            [
                'pricing_rule_id' => $request->pricing_rule_id,
            ]
        );
        return response(
            $productPricing,
            Response::HTTP_CREATED
        );
    }
}
