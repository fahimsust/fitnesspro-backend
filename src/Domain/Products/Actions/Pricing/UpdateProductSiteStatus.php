<?php

namespace Domain\Products\Actions\Pricing;

use Domain\Products\Models\Product\ProductPricing;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductSiteStatus
{
    use AsObject;

    public function handle(
        ProductPricing $productPricing,
        bool $status,
    ): ProductPricing {
        $productPricing->update(
            [
                'status' => $status,
            ]
        );

        return $productPricing;
    }
}
