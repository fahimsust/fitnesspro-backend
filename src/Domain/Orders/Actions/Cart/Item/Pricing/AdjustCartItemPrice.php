<?php

namespace Domain\Orders\Actions\Cart\Item\Pricing;

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Enums\AmountAdjustmentTypes;

class AdjustCartItemPrice
{
    use AsObject;

    public function handle(
        CartItem $item,
        int $adjustmentAmount,
        AmountAdjustmentTypes $type
    ) {
        if ($adjustmentAmount === 0) {
            return;
        }

        $item->update([
            'price_reg' => $type->adjustAmount($adjustmentAmount, $item->price_reg),
            'price_sale' => $type->adjustAmount($adjustmentAmount, $item->price_sale),
        ]);
    }
}
