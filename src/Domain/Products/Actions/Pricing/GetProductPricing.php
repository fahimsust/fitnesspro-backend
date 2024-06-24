<?php

namespace Domain\Products\Actions\Pricing;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductPricing
{
    use AsObject;

    public function handle(
        Product $product,
        ?int $site_id = null,
    ): ?ProductPricing {
        return $product->pricing()->whereSiteId($site_id)->firstOrFail();
    }
}
