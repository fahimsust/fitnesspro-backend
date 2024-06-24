<?php

namespace Tests\Unit\Domain\Orders\Models\Carts\Items;

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemOption;
use Domain\Orders\Models\Carts\CartItems\CartItemOptionCustomValueUNUSED;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Tests\TestCase;

class CartItemOptionTest extends TestCase
{


    private CartItemOption $itemOption;

    protected function setUp(): void
    {
        parent::setUp();

        $this->itemOption = CartItemOption::factory()->create();
    }

    /** @test */
    public function can_get_item()
    {
        $this->assertInstanceOf(CartItem::class, $this->itemOption->item);
    }

    /** @test */
    public function can_get_option_value()
    {
        $this->assertInstanceOf(
            ProductOptionValue::class,
            $this->itemOption->optionValue
        );
    }

    /** @test */
    public function can_get_option()
    {
        $this->assertInstanceOf(
            ProductOption::class,
            $this->itemOption->option
        );
    }
}
