<?php

namespace Domain\Products\Actions\Pricing;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadProductPricingForSiteFromCache extends AbstractAction
{
    public function __construct(
        public Product $product,
        public int     $siteId,
    )
    {
    }

    public function execute(): ProductPricing
    {
        return Cache::tags([
            "product-site-pricing-cache.{$this->product->id}.{$this->siteId}",
        ])
            ->remember(
                $this->cacheKey(),
                60 * 5,
                fn() => ProductPricing::query()
                    ->where('product_id', $this->product->id)
                    ->where('site_id', $this->siteId)
                    ->first()
                    ?? throw new ModelNotFoundException(
                        __("No product pricing matching product ID {$this->product->id} and site ID {$this->siteId}.")
                    )
            );
    }

    protected function cacheKey(): string
    {
        return 'load-product-pricing-by-site.'
            . $this->product->id . '.' . $this->siteId;
    }
}
