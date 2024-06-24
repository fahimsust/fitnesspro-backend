<?php

namespace Domain\Orders\Actions\Cart\Item\Pricing;

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Pricing\PricingRuleLevel;
use Support\Contracts\AbstractAction;
use Support\Traits\HasExceptionCollection;

class CheckAndApplyVolumePricingToCartItem extends AbstractAction
{
    use HasExceptionCollection;

    public function __construct(
        private CartItem $item
    )
    {
    }


    public function execute(): void
    {
        $pricing = $this->item->product->pricingBySite(
            $this->item->cart->site
        );

        if (is_null($pricing->pricing_rule_id)) {
            return;
        }

        if ($pricing->pricingRule->levels->isEmpty()) {
            return;
        }

        $this->applyLevel(
            $pricing->pricingRule->levels
                ->firstWhere(
                    fn (PricingRuleLevel $level) => $level->min_qty <= $this->item->qty
                        && (! $level->max_qty || $level->max_qty >= $this->item->qty)
                )
        );
    }

    private function applyLevel(PricingRuleLevel $level)
    {
        AdjustCartItemPrice::run(
            $this->item,
            $level->amount * -1,
            $level->amount_type
        );
    }
}
