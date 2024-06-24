<?php

namespace Tests\Feature\Domain\Orders\Actions\Cart;

use Domain\Orders\Actions\Cart\EmptyCart;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Tests\TestCase;

class EmptyCartTest extends TestCase
{


    /** @test */
    public function can_empty()
    {
        CartItem::factory(3)->create();
        CartDiscountAdvantage::factory()->create();

        /** @var Cart $cart */
        $cart = Cart::with(['items', 'discountAdvantages'])
            ->first();

        $this->assertCount(3, $cart->items);
        $this->assertCount(1, $cart->discountAdvantages);
        $this->assertFalse($cart->isEmpty());

        $result = EmptyCart::run($cart);

        $this->assertTrue($cart->refresh()->isEmpty());
    }
}
