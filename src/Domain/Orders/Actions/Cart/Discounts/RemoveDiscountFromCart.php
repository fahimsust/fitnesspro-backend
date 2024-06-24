<?php

namespace Domain\Orders\Actions\Cart\Discounts;

use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Support\Contracts\AbstractAction;

class RemoveDiscountFromCart extends AbstractAction
{
    private CartDiscount $cartDiscount;

    public function __construct(
        public Cart $cart,
        public int  $cartDiscountId,
    )
    {
    }

    public function execute(): static
    {
        $this->cartDiscount = $this->cart
            ->cartDiscounts()
            ->whereId($this->cartDiscountId)
            ->first()
            ?? throw new ModelNotFoundException(
                __('Could not find discount in cart')
            );

        //should delete (via foreign keys):
        // CartDiscountAdvantage,
        // CartItemDiscountAdvantage,
        // CartItemDiscountCondition,
        // CartDiscountCode
        $this->cartDiscount->delete();

        $this->cart->clearCaches();

        return $this;
    }

    public function result(): Cart
    {
        return $this->cart;
    }
}
