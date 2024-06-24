<?php

namespace Domain\Products\Actions\Pricing;

use Domain\Products\Models\Product\ProductPricing;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductPrice
{
    use AsObject;

    public function handle(
        ?ProductPricing $productPricing,
    ): float {
        if ($productPricing) {
            return $productPricing->price();
        }
        return 0.00;
    }
}
