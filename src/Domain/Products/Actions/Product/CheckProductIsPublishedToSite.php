<?php

namespace Domain\Products\Actions\Product;

use Domain\Products\Exceptions\NotPublishedToSite;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Contracts\AbstractAction;

class CheckProductIsPublishedToSite extends AbstractAction
{
    public function __construct(
        public Site $site,
        public Product $product,
        public ?ProductPricing $pricing = null
    ) {
    }

    public function execute(): bool
    {
        if (! $this->product->isActive() || ! $this->getPricing()->isActive()) {
            throw new NotPublishedToSite(__('Product :title is not currently available', [
                'title' => $this->product->title,
            ]));
        }

        return true;
    }

    private function getPricing(): ProductPricing
    {
        return $this->pricing
            ?? $this->product->pricingBySiteCached($this->site);
    }
}
