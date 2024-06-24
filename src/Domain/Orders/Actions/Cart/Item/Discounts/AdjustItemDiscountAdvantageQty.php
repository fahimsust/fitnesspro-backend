<?php

namespace Domain\Orders\Actions\Cart\Item\Discounts;

use Domain\Orders\Models\Carts\CartItems\CartItemDiscountAdvantage;
use Lorisleiva\Actions\Concerns\AsObject;

class AdjustItemDiscountAdvantageQty
{
    use AsObject;

    public function handle(
        CartItemDiscountAdvantage $itemAdvantage,
        int $qty
    ) {
        $qty > 0
            ? $itemAdvantage->increment('qty', $qty)
            : $itemAdvantage->decrement('qty', $qty);
    }
}
