<?php

namespace Tests\Unit\Domain\Orders\Models\Carts\Items\Discounts;

use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountCondition;
use Tests\TestCase;

class CartItemDiscountConditionTest extends TestCase
{


    private CartItemDiscountCondition $itemCondition;

    protected function setUp(): void
    {
        parent::setUp();

        $this->itemCondition = CartItemDiscountCondition::factory()->create();
    }

    /** @test */
    public function can_get_item()
    {
        $this->assertInstanceOf(CartItem::class, $this->itemCondition->item);
    }

    /** @test */
    public function can_get_condition()
    {
        $this->assertInstanceOf(
            DiscountCondition::class,
            $this->itemCondition->condition
        );
    }

    /** @test */
    public function can_get_discount()
    {
        $this->assertInstanceOf(
            Discount::class,
            $this->itemCondition->discount
        );
    }
}
