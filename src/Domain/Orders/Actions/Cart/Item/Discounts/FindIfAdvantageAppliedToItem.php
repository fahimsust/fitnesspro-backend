<?php

namespace Domain\Orders\Actions\Cart\Item\Discounts;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountAdvantage;
use Lorisleiva\Actions\Concerns\AsObject;

class FindIfAdvantageAppliedToItem
{
    use AsObject;

    public function handle(
        CartItem $item,
        DiscountAdvantage $advantage
    ): CartItemDiscountAdvantage|bool {
        return $item->discountAdvantages->firstWhere(
            function (CartItemDiscountAdvantage $itemAdvantage) use ($advantage) {
                return $itemAdvantage->advantage_id === $advantage->id;
            }
        )
            ?? false;
    }
}
