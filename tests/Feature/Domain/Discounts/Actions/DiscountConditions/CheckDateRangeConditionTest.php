<?php

namespace Tests\Feature\Domain\Discounts\Actions\DiscountConditions;

use Carbon\Carbon;
use Domain\Discounts\Actions\CheckDiscountCondition;
use Domain\Discounts\Dtos\DiscountCheckerData;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemOption;
use Domain\Products\Enums\ProductOptionTypes;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Tests\TestCase;


class CheckDateRangeConditionTest extends TestCase
{
    public Cart $cart;
    public DiscountCondition $discountCondition;

    /** @test */
    public function check_condition_match()
    {
        $this->createCartAndDiscount();

        $this->assertTrue(
            CheckDiscountCondition::now(
                new DiscountCheckerData(),
                $this->discountCondition,
                $this->cart,
            )
        );
    }

    /** @test */
    public function check_condition_not_match_start_date()
    {
        $this->createCartAndDiscount(9);

        $this->assertFalse(
            CheckDiscountCondition::now(
                new DiscountCheckerData(),
                $this->discountCondition,
                $this->cart,
            )
        );
    }

    /** @test */
    public function check_condition_not_match_end_date()
    {
        $this->createCartAndDiscount(5, 8);

        $this->assertFalse(
            CheckDiscountCondition::now(
                new DiscountCheckerData(),
                $this->discountCondition,
                $this->cart,
            )
        );
    }

    private function createCartAndDiscount(
        $startBefore = 5,
        $endAfter = 5
    )
    {
        $discount = Discount::factory()->create();
        $discountRule = DiscountRule::factory()->create(['discount_id' => $discount->id]);
        $startDate = Carbon::now()->subDays(7)->startOfDay();
        $endDate = Carbon::now()->addDays(7)->startOfDay();
        $this->discountCondition = DiscountCondition::factory()->create(
            [
                'rule_id' => $discountRule->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'condition_type_id' => DiscountConditionTypes::DATE_RANGE->value
            ]
        );
        $this->cart = Cart::factory()->create();
        $products = Product::factory(3)->create();
        foreach ($products as $key => $product) {
            $startDate = Carbon::now()->subDays($startBefore)->startOfDay();
            $endDate = Carbon::now()->addDays($endAfter)->startOfDay();

            //make one option not match
            if ($key == 2) {
                $endDate = Carbon::now()->addDays(15)->startOfDay();
            }
            CartItem::factory()->create([
                'product_id' => $product->id,
                'cart_id' => $this->cart->id,
            ]);
            $productOption = ProductOption::factory()->create(
                [
                    'type_id' => ProductOptionTypes::DateRange
                ]
            );
            $productOptionValue = ProductOptionValue::factory()->create([
                'option_id' => $productOption->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
            CartItemOption::factory()->create(
                [
                    'option_value_id' => $productOptionValue->id
                ]
            );
        }
    }
}
