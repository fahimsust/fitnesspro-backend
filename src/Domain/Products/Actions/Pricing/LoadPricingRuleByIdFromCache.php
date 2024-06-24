<?php

namespace Domain\Products\Actions\Pricing;

use Domain\Products\Exceptions\ProductNotFoundException;
use Domain\Products\Models\Product\Pricing\PricingRule;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadPricingRuleByIdFromCache extends AbstractAction
{
    public function __construct(
        public int $pricingRuleId,
    )
    {
    }

    public function execute(): Product
    {
        return Cache::tags([
            "pricing-rule-cache.{$this->pricingRuleId}"
        ])
            ->remember(
                'load-pricing-rule-by-id.' . $this->pricingRuleId,
                60 * 5,
                fn() => PricingRule::find($this->pricingRuleId)
                    ?? throw new ModelNotFoundException(
                        __("No pricing rule matching ID {$this->pricingRuleId}.")
                    )
            );
    }
}
