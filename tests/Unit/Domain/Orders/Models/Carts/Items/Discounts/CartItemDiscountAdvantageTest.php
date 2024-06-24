<?php

namespace Tests\Unit\Domain\Orders\Models\Carts\Items\Discounts;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountAdvantage;
use Tests\TestCase;

class CartItemDiscountAdvantageTest extends TestCase
{
    private CartItemDiscountAdvantage $itemAdvantage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->itemAdvantage = CartItemDiscountAdvantage::factory()->create();
    }

    /** @test */
    public function can_get_item()
    {
        $this->assertInstanceOf(CartItem::class, $this->itemAdvantage->item);
    }

    /** @test */
    public function can_get_advantage()
    {
        $this->assertInstanceOf(
            DiscountAdvantage::class,
            $this->itemAdvantage->advantage
        );
    }

    /** @test */
    public function can_get_discount()
    {
        $this->assertInstanceOf(
            Discount::class,
            $this->itemAdvantage->discount
        );
    }
}
