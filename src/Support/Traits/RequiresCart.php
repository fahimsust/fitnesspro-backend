<?php

namespace Support\Traits;

use Domain\Orders\Models\Carts\Cart;

trait RequiresCart
{
    public Cart $cart;

    public function cart(Cart $cart)
    {
        $this->cart = $cart;

        return $this;
    }
}
