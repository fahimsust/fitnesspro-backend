<?php

namespace Domain\Orders\Actions\Order\Package\Item\Pricing;

use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Products\Models\Product\Pricing\PricingRuleLevel;
use Support\Contracts\AbstractAction;
use Support\Traits\HasExceptionCollection;

class CheckAndApplyVolumePricingToOrderItem extends AbstractAction
{
    use HasExceptionCollection;

    public function __construct(
        private OrderItem $item
    )
    {
    }

    public function execute(): void
    {
        $pricing = $this->item->product->pricingBySite(
            $this->item->order->site
        );

        if (is_null($pricing->pricing_rule_id)) {
            return;
        }

        if (!$pricing->pricingRule->levels->count()) {
            return;
        }

        $this->applyLevel(
            $pricing->pricingRule->levels
                ->firstWhere(
                    fn(PricingRuleLevel $level) => $level->min_qty <= $this->item->qty
                        && (!$level->max_qty || $level->max_qty >= $this->item->qty)
                )
        );
    }

    private function applyLevel(PricingRuleLevel $level)
    {
        AdjustOrderItemPrice::run(
            $this->item,
            $level->amount * -1,
            $level->amount_type
        );
    }
}
