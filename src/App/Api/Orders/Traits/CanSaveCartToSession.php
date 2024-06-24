<?php

namespace App\Api\Orders\Traits;

use Domain\Orders\Actions\Cart\SaveCartToSession;
use Domain\Orders\Models\Carts\Cart;

trait CanSaveCartToSession
{
    public Cart $cart;

    public function saveCartToSession(): static
    {
        SaveCartToSession::run($this->cart);

        return $this;
    }
}
