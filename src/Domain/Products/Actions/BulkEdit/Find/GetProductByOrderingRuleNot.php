<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetOrderingRuleError;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByOrderingRuleNot
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ) {
        $products = [];
        GetOrderingRuleError::run($request);
        $productPricings = ProductPricing::where('ordering_rule_id',$request->ordering_rule_id)
        ->groupBy('product_id')
        ->limit(1000)
        ->get();
        if($productPricings)
        {
            $products = Product::whereNotIn('id',$productPricings->pluck('product_id')->toArray())
            ->limit(1000)
            ->get();
        }

        return $products;
    }
}
