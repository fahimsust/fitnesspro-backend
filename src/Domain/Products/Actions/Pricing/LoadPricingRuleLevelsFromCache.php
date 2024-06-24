<?php

namespace Domain\Products\Actions\Pricing;

use Domain\Products\Models\Product\Pricing\PricingRuleLevel;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadPricingRuleLevelsFromCache extends AbstractAction
{
    public function __construct(
        public int $pricingRuleId,
    )
    {
    }

    public function execute(): Collection
    {
        return Cache::tags([
            "pricing-rule-levels-cache.{$this->pricingRuleId}"
        ])
            ->remember(
                'load-pricing-rule-levels-by-rule-id.' . $this->pricingRuleId,
                60 * 5,
                fn() => PricingRuleLevel::query()
                    ->where('rule_id', $this->pricingRuleId)
                    ->get()
            );
    }
}
