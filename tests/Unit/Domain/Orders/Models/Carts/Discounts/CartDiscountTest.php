<?php

namespace Tests\Unit\Domain\Orders\Models\Carts\Discounts;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountCode;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountAdvantage;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountCondition;
use Tests\TestCase;

class CartDiscountTest extends TestCase
{
    private CartDiscount $cartDiscount;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartDiscount = CartDiscount::factory()->create();
    }

    /** @test */
    public function can_get_cart()
    {
        $this->assertInstanceOf(
            Cart::class,
            $this->cartDiscount->cart
        );
    }

    /** @test */
    public function can_get_discount()
    {
        $this->assertInstanceOf(
            Discount::class,
            $this->cartDiscount->discount
        );
    }

    /** @test */
    public function can_get_codes()
    {
        CartDiscountCode::factory(3)
            ->for($this->cartDiscount)
            ->create([
                'condition_id' => DiscountCondition::factory()
            ]);

        $this->assertCount(3, $this->cartDiscount->codes);
        $this->assertInstanceOf(
            CartDiscountCode::class,
            $this->cartDiscount->codes->first()
        );
    }

    /** @test */
    public function can_get_advantages()
    {
        CartDiscountAdvantage::factory(3)
            ->for($this->cartDiscount)
            ->create([
                'advantage_id' => DiscountAdvantage::factory()
            ]);

        $this->assertCount(3, $this->cartDiscount->advantages);
        $this->assertInstanceOf(
            CartDiscountAdvantage::class,
            $this->cartDiscount->advantages->first()
        );
    }

    /** @test */
    public function can_get_item_advantages()
    {
        CartItemDiscountAdvantage::factory(3)
            ->for($this->cartDiscount)
            ->create([
                'item_id' => CartItem::factory()
            ]);

        $this->assertCount(3, $this->cartDiscount->itemAdvantages);
        $this->assertInstanceOf(
            CartItemDiscountAdvantage::class,
            $this->cartDiscount->itemAdvantages->first()
        );
    }

    /** @test */
    public function can_get_item_conditions()
    {
        CartItemDiscountCondition::factory(3)
            ->for($this->cartDiscount)
            ->create([
                'item_id' => CartItem::factory()
            ]);

        $this->assertCount(3, $this->cartDiscount->itemConditions);
        $this->assertInstanceOf(
            CartItemDiscountCondition::class,
            $this->cartDiscount->itemConditions->first()
        );
    }
}
