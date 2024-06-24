<?php

namespace Tests\Feature\Domain\Orders\Traits;

use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;

trait TestsCart
{
    protected Cart $cart;
    protected CartItem $cartItem;

    protected function createCart(): Cart
    {
        return $this->cart = Cart::factory()
            ->create([
                'account_id' => null,
            ]);
    }

    protected function createCartWithItem(): CartItem
    {
        return $this->cartItem = CartItem::factory(['qty' => 1])
            ->for($this->createCart())
            ->create();
    }
}
