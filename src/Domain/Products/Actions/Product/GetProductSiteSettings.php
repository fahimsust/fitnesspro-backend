<?php

namespace Domain\Products\Actions\Product;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessory;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductSiteSettings
{
    use AsObject;

    public function handle(
        Product $product,
        ?int $site_id,
    ): ProductAccessory {
        return $product->siteSettings()->whereSiteId($site_id)->firstOrFail();
    }
}
