<?php

namespace Domain\Orders\Exceptions;

use Domain\Orders\Models\Carts\Cart;
use Exception;

class CartNotAllowedCheckoutException extends Exception
{
    public static function check(Cart $cart): void
    {
        if ($cart->isForRegistration()) {
            throw new static(
                __("Cart is assigned to a registration, can't be used in checkout.")
            );
        }
    }
}
