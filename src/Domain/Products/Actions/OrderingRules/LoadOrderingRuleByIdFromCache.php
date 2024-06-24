<?php

namespace Domain\Products\Actions\OrderingRules;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\Product\Pricing\PricingRule;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadOrderingRuleByIdFromCache extends AbstractAction
{
    public function __construct(
        public int $orderingRuleId,
    )
    {
    }

    public function execute(): Product
    {
        return Cache::tags([
            "ordering-rule-cache.{$this->orderingRuleId}"
        ])
            ->remember(
                'load-ordering-rule-by-id.' . $this->orderingRuleId,
                60 * 5,
                fn() => OrderingRule::find($this->orderingRuleId)
                    ?? throw new ModelNotFoundException(
                        __("No ordering rule matching ID {$this->orderingRuleId}.")
                    )
            );
    }
}
