<?php

namespace Tests\Unit\Domain\Orders\Models\Carts\Discounts;

use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountCode;
use Tests\TestCase;

class CartDiscountCodeTest extends TestCase
{
    private CartDiscountCode $discountCode;

    protected function setUp(): void
    {
        parent::setUp();

        $this->discountCode = CartDiscountCode::factory()->create();
    }

    /** @test */
    public function can_get_cart()
    {
        $this->assertInstanceOf(
            Cart::class,
            $this->discountCode->cart
        );
    }

    /** @test */
    public function can_get_cart_discount()
    {
        $this->assertInstanceOf(
            CartDiscount::class,
            $this->discountCode->cartDiscount
        );
    }

    /** @test */
    public function can_get_condition()
    {
        $this->assertInstanceOf(
            DiscountCondition::class,
            $this->discountCode->condition
        );
    }

    /** @test */
    public function can_get_discount()
    {
        $this->assertInstanceOf(
            Discount::class,
            $this->discountCode->discount
        );
    }
}
