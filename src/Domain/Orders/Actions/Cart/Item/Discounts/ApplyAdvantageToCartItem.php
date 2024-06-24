<?php

namespace Domain\Orders\Actions\Cart\Item\Discounts;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountAdvantage;
use Lorisleiva\Actions\Concerns\AsObject;

class ApplyAdvantageToCartItem
{
    use AsObject;

    public function handle(
        CartDiscount $cartDiscount,
        DiscountAdvantage $advantage,
        CartItem $item,
        int $availableQtyToApply,
    ): CartItemDiscountAdvantage {
        return $cartDiscount->itemAdvantages()->create([
            'item_id' => $item->id,
            'advantage_id' => $advantage->id,
            'qty' => $this->qtyToApply($item, $availableQtyToApply),
            'amount' => $advantage->amount,
        ]);
    }

    private function qtyToApply(CartItem $item, int $availableQtyToApply): int
    {
        if ($item->qty >= $availableQtyToApply) {
            return $availableQtyToApply;
        }

        return $item->qty;
    }
}
