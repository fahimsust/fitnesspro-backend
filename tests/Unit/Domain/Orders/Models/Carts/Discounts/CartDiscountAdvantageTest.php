<?php

namespace Tests\Unit\Domain\Orders\Models\Carts\Discounts;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Support\Helpers\Query;
use Tests\TestCase;

class CartDiscountAdvantageTest extends TestCase
{
    private CartDiscountAdvantage $discountAdvantage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->discountAdvantage = CartDiscountAdvantage::factory()->create();
    }

    /** @test */
    public function can_get_cart()
    {
        $this->assertInstanceOf(
            Cart::class,
            $this->discountAdvantage->cart
        );
    }

    /** @test */
    public function can_get_advantage()
    {
        $this->assertInstanceOf(
            DiscountAdvantage::class,
            $this->discountAdvantage->advantage
        );
    }

    /** @todo */
    public function can_get_discount()
    {
        $this->assertInstanceOf(
            Discount::class,
            $this->discountAdvantage->discount
        );
    }
}
