<?php

namespace Domain\Orders\Actions\Cart;

use Domain\Orders\Models\Carts\Cart;
use Lorisleiva\Actions\Concerns\AsObject;

class SaveCartToSession
{
    use AsObject;

    public function handle(Cart $cart): void
    {
        session()->put('cart', $cart->toArray());
    }
}
