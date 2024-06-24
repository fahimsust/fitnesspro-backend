<?php

namespace Domain\Orders\Actions\Cart;

use Domain\Orders\Models\Carts\Cart;
use Lorisleiva\Actions\Concerns\AsObject;

class EmptyCart
{
    use AsObject;

    public function handle(Cart $cart): Cart
    {
        $cart->cartDiscounts()->delete();
        $cart->items()->delete();

        return $cart;
    }
}
