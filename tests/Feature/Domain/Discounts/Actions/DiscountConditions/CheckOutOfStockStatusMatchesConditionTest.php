<?php

namespace Tests\Feature\Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Actions\CheckDiscountCondition;
use Domain\Discounts\Dtos\DiscountCheckerData;
use Domain\Discounts\Enums\DiscountConditionRequiredQtyTypes;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\ConditionOutOfStockStatus;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAvailability;
use Domain\Products\Models\Product\ProductPricing;
use Tests\TestCase;


class CheckOutOfStockStatusMatchesConditionTest extends TestCase
{
    public Cart $cart;
    public DiscountCondition $discountCondition;

    /** @test */
    public function check_condition_match_combined()
    {
        $this->createCartAndDiscount();

        $value = CheckDiscountCondition::now(
            new DiscountCheckerData(),
            $this->discountCondition,
            $this->cart,
        );

        $this->assertTrue($value);
        $previousCart = $this->cart;

        $this->createCartAndDiscount(
            DiscountConditionRequiredQtyTypes::Combined,
            3,
            0,
            true
        );

        $value = CheckDiscountCondition::now(
            new DiscountCheckerData(),
            $this->discountCondition,
            $this->cart,
        );

        $this->assertFalse($value);

        $value = CheckDiscountCondition::now(
            new DiscountCheckerData(),
            $this->discountCondition,
            $previousCart,
        );

        $this->assertTrue($value);
    }

    /** @test */
    public function check_condition_match_individuals()
    {
        $this->createCartAndDiscount(
            DiscountConditionRequiredQtyTypes::Individual,
            4,
            3
        );

        $value = CheckDiscountCondition::now(
            new DiscountCheckerData(),
            $this->discountCondition,
            $this->cart,
        );

        $this->assertTrue($value);

        $previousCart = $this->cart;
        $this->createCartAndDiscount(
            DiscountConditionRequiredQtyTypes::Individual,
            4,
            3,
            1
        );

        $value = CheckDiscountCondition::now(
            new DiscountCheckerData(),
            $this->discountCondition,
            $this->cart,
        );

        $this->assertFalse($value);

        $value = CheckDiscountCondition::now(
            new DiscountCheckerData(),
            $this->discountCondition,
            $previousCart,
        );

        $this->assertTrue($value);
    }

    /** @test */
    public function check_condition_not_match_combined()
    {
        $this->createCartAndDiscount(
            DiscountConditionRequiredQtyTypes::Combined,
            4
        );

        $value = CheckDiscountCondition::now(
            new DiscountCheckerData(),
            $this->discountCondition,
            $this->cart,
        );

        $this->assertFalse($value);

        $previousCart = $this->cart;
        $this->createCartAndDiscount(
            DiscountConditionRequiredQtyTypes::Combined,
            4
        );

        $value = CheckDiscountCondition::now(
            new DiscountCheckerData(),
            $this->discountCondition,
            $previousCart,
        );

        $this->assertFalse($value);
    }

    /** @test */
    public function check_condition_not_match_individuals()
    {
        $this->createCartAndDiscount(
            DiscountConditionRequiredQtyTypes::Individual,
            3,
            4
        );

        $value = CheckDiscountCondition::now(
            new DiscountCheckerData(),
            $this->discountCondition,
            $this->cart,
        );

        $this->assertFalse($value);

        $previousCart = $this->cart;
        $this->createCartAndDiscount(
            DiscountConditionRequiredQtyTypes::Individual,
            0,
            4
        );

        $value = CheckDiscountCondition::now(
            new DiscountCheckerData(),
            $this->discountCondition,
            $previousCart,
        );

        $this->assertFalse($value);
    }

    private function createCartAndDiscount(
        DiscountConditionRequiredQtyTypes $required_qty_type = DiscountConditionRequiredQtyTypes::Combined,
                                          $required_qty_combined = 3,
                                          $required_qty = 3,
                                          $equals_notequals = 0
    )
    {
        $discount = Discount::factory()->create();
        $discountRule = DiscountRule::factory()->create(['discount_id' => $discount->id]);
        $this->discountCondition = DiscountCondition::factory()->create(
            [
                'rule_id' => $discountRule->id,
                'required_qty_type' => $required_qty_type,
                'required_qty_combined' => $required_qty_combined,
                'equals_notequals' => $equals_notequals,
                'condition_type_id' => DiscountConditionTypes::OUT_OF_STOCK_STATUS->value
            ]
        );

        $productAvailability = ProductAvailability::factory()->create();
        ConditionOutOfStockStatus::factory()->create([
            'outofstockstatus_id' => $productAvailability->id,
            'required_qty' => $required_qty,
            'condition_id' => $this->discountCondition->id
        ]);

        $this->cart = Cart::factory()->create();
        $products = Product::factory(3)
            ->create([
                'default_outofstockstatus_id' => $productAvailability->id
            ])
            ->each(function (Product $product) {
                ProductPricing::factory()
                    ->for($product)
                    ->for(site())
                    ->create();

                CartItem::factory()->create([
                    'product_id' => $product->id,
                    'cart_id' => $this->cart->id,
                    'qty' => 1
                ]);
            });
    }
}
