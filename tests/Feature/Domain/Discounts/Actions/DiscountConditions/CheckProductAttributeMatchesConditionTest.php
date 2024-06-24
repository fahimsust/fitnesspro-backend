<?php

namespace Tests\Feature\Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Actions\CheckDiscountCondition;
use Domain\Discounts\Dtos\DiscountCheckerData;
use Domain\Discounts\Enums\DiscountConditionRequiredQtyTypes;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\ConditionAttribute;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Distributors\Models\Distributor;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductDistributor;
use Domain\Products\Models\Product\ProductPricing;
use Tests\TestCase;


class CheckProductAttributeMatchesConditionTest extends TestCase
{
    public Cart $cart;
    public DiscountCondition $discountCondition;

    /** @test */
    public function check_condition_match_combined()
    {
        $this->createCartAndDiscount();

        $value = (new CheckDiscountCondition(
            new DiscountCheckerData(),
            $this->discountCondition,
            $this->cart,
        ))->execute();

        $this->assertTrue($value);
        $previousCart = $this->cart;

        $this->createCartAndDiscount(
            DiscountConditionRequiredQtyTypes::Combined,
            3,
            0,
            1
        );

        $value = (new CheckDiscountCondition(
            new DiscountCheckerData(),
            $this->discountCondition,
            $this->cart,
        ))->execute();

        $this->assertFalse($value);

        $value = (new CheckDiscountCondition(
            new DiscountCheckerData(),
            $this->discountCondition,
            $previousCart,
        ))->execute();

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

        $value = (new CheckDiscountCondition(
            new DiscountCheckerData(),
            $this->discountCondition,
            $this->cart,
        ))->execute();

        $this->assertTrue($value);

        $previousCart = $this->cart;
        $this->createCartAndDiscount(
            DiscountConditionRequiredQtyTypes::Individual,
            4,
            3,
            1
        );

        $value = (new CheckDiscountCondition(
            new DiscountCheckerData(),
            $this->discountCondition,
            $this->cart,
        ))->execute();

        $this->assertFalse($value);

        $value = (new CheckDiscountCondition(
            new DiscountCheckerData(),
            $this->discountCondition,
            $previousCart,
        ))->execute();

        $this->assertTrue($value);
    }

    /** @test */
    public function check_condition_not_match_combined()
    {
        $this->createCartAndDiscount(
            DiscountConditionRequiredQtyTypes::Combined,
            4
        );

        $value = (new CheckDiscountCondition(
            new DiscountCheckerData(),
            $this->discountCondition,
            $this->cart,
        ))->execute();

        $this->assertFalse($value);

        $previousCart = $this->cart;
        $this->createCartAndDiscount(
            DiscountConditionRequiredQtyTypes::Combined,
            4
        );

        $value = (new CheckDiscountCondition(
            new DiscountCheckerData(),
            $this->discountCondition,
            $previousCart,
        ))->execute();

        $this->assertFalse($value);
    }

    /** @test */
    public function check_condition_not_match_individuals()
    {
        $this->createCartAndDiscount(
            DiscountConditionRequiredQtyTypes::Individual,
            0,
            4
        );

        $value = (new CheckDiscountCondition(
            new DiscountCheckerData(),
            $this->discountCondition,
            $this->cart,
        ))->execute();

        $this->assertFalse($value);

        $previousCart = $this->cart;
        $this->createCartAndDiscount(
            DiscountConditionRequiredQtyTypes::Individual,
            0,
            4
        );

        $value = (new CheckDiscountCondition(
            new DiscountCheckerData(),
            $this->discountCondition,
            $previousCart,
        ))->execute();

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
                'condition_type_id' => DiscountConditionTypes::REQUIRED_ATTRIBUTE_OPTION->value
            ]
        );

        $attributeOption = AttributeOption::factory()->create();
        ConditionAttribute::factory()->create([
            'attributevalue_id' => $attributeOption->id,
            'required_qty' => $required_qty,
            'condition_id' => $this->discountCondition->id
        ]);

        $this->cart = Cart::factory()->create();
        $products = Product::factory(3)
            ->create([
                'default_distributor_id' => Distributor::factory()
            ]);

        foreach ($products as $product) {
            ProductDistributor::factory()
                ->for($product)
                ->for($product->defaultDistributor, 'distributor')
                ->create();

            ProductPricing::factory()
                ->for($product)
                ->for(site())
                ->create();

            ProductDetail::factory()
                ->for($product)
                ->create([
                    'attributes' => [$attributeOption->id]
                ]);

            ProductAttribute::factory()->create([
                'product_id' => $product->id,
                'option_id' => $attributeOption->id
            ]);

            CartItem::factory()->create([
                'product_id' => $product->id,
                'cart_id' => $this->cart->id,
                'qty' => 1
            ]);
        }
    }
}
