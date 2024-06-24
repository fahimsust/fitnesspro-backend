<?php

namespace Domain\Products\Actions\Pricing;

use App\Api\Admin\Products\Requests\ProductPricingRequest;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductPricing
{
    use AsObject;

    public function handle(
        Product $product,
        ProductPricingRequest $request,
    ): ProductPricing {
        $product->pricing()->updateOrCreate(
            [
                'site_id' => $request->site_id,
            ],
            [
                'price_reg' => $request->price_reg,
                'price_sale' => $request->price_sale,
                'onsale' => $request->onsale,
                'min_qty' => $request->min_qty,
                'max_qty' => $request->max_qty,
                'feature' => $request->feature,
                'pricing_rule_id' => $request->pricing_rule_id,
                'ordering_rule_id' => $request->ordering_rule_id,
            ]
        );
        return ProductPricing::whereProductId($product->id)->whereSiteId($request->site_id)->with('site','orderingRule','pricingRule')->first();
    }
}
