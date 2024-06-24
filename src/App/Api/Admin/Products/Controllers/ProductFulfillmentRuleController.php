<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductFulfillmentRuleRequest;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductFulfillmentRuleController extends AbstractController
{
    public function __invoke(Product $product, ProductFulfillmentRuleRequest $request)
    {
        $product->update(
            [
                'fulfillment_rule_id' => $request->fulfillment_rule_id,
            ]
        );
        return response(
            $product->fulfillmentRule,
            Response::HTTP_CREATED
        );
    }
}
