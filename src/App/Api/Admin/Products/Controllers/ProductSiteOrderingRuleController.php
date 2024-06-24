<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductSiteOrderingRuleRequest;
use Domain\Products\Actions\Pricing\GetProductPricing;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductSiteOrderingRuleController extends AbstractController
{
    public function __invoke(Product $product, ProductSiteOrderingRuleRequest $request)
    {
        $productPricing = GetProductPricing::run($product, $request->site_id);
        $productPricing->update(
            [
                'ordering_rule_id' => $request->ordering_rule_id,
            ]
        );
        return response(
            $productPricing,
            Response::HTTP_CREATED
        );
    }
}
