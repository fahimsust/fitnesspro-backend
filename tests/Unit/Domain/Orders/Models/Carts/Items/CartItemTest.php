<?php

namespace Tests\Unit\Domain\Orders\Models\Carts\Items;

use Domain\CustomForms\Models\CustomField;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Distributors\Models\Distributor;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemCustomField;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountAdvantage;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountCondition;
use Domain\Orders\Models\Carts\CartItems\CartItemOption;
use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Domain\Products\Models\Product\AccessoryField\AccessoryFieldProduct;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CartItemTest extends TestCase
{


    private CartItem $item;

    protected function setUp(): void
    {
        parent::setUp();

        $this->item = CartItem::factory()->create();
    }

    /** @test */
    public function can_get_unit_price()
    {
        $this->item->onsale = false;
        $this->assertEquals(
            $this->item->price_reg,
            $this->item->unitPrice()
        );

        $this->item->onsale = true;
        $this->assertEquals(
            $this->item->price_sale,
            $this->item->unitPrice()
        );
    }

    /** @todo */
    public function can_get_totals()
    {
        $this->assertGreaterThan(0, $this->item->subTotal());
        $this->assertEquals(
            $this->item->unitPrice() * $this->item->qty,
            $this->item->subTotal()
        );

        CartItemDiscountAdvantage::factory(2)->create([
            'advantage_id' => DiscountAdvantage::factory()
        ]);

        $this->assertGreaterThan(0, $this->item->discountTotal());
        $this->assertEquals(
            $this->item
                ->discountAdvantages()
                ->withWhereHas(
                    'discount',
                    fn(Builder $query) => $query->active()
                )
                ->sum(DB::raw('qty * amount')),
            $this->item->discountTotal()
        );

        $this->assertGreaterThan(0, $this->item->totalAmount());
        $this->assertEquals(
            $this->item->subTotal() - $this->item->discountTotal(),
            $this->item->totalAmount()
        );

        $this->assertGreaterThan(0, $this->item->weightTotal());
        $this->assertEquals(
            $this->item->qty * $this->item->product->weight,
            $this->item->weightTotal()
        );
    }

    /** @test */
    public function can_get_cart()
    {
        $this->assertInstanceOf(Cart::class, $this->item->cart);
    }

    /** @test */
    public function can_get_product()
    {
        $this->assertInstanceOf(Product::class, $this->item->product);
    }

    /** @test */
    public function can_get_parent_product()
    {
        $this->item->update([
            'parent_product' => Product::factory()->create()->id
        ]);

        $this->assertInstanceOf(Product::class, $this->item->parentProduct);
    }

    /** @test */
    public function can_get_parent_cart_item()
    {
        $this->item->update([
            'parent_cart_item_id' => CartItem::factory()->create()->id
        ]);

        $this->assertInstanceOf(CartItem::class, $this->item->parentItem);
    }

    /** @test */
    public function can_get_required_for()
    {
        $this->item->update([
            'required' => CartItem::factory()->create()->id
        ]);

        $this->assertInstanceOf(CartItem::class, $this->item->requiredFor);
    }

    /** @test */
    public function can_get_options()
    {
        CartItemOption::factory(2)->create([
            'option_value_id' => ProductOptionValue::factory(),
            'item_id' => $this->item->id,
        ]);

        $options = $this->item->optionValues;

        $this->assertCount(2, $options);
        $this->assertInstanceOf(CartItemOption::class, $options->first());
    }

    /** @todo */
    public function can_get_custom_fields()
    {
        CartItemCustomField::factory(2)->create([
            'field_id' => CustomField::factory()
        ]);

        $fields = $this->item->customFields;

        $this->assertCount(2, $fields);
        $this->assertInstanceOf(CartItemCustomField::class, $fields->first());
    }

    //not needed right now
//    /** @todo */
//    public function can_get_registry_item()
//    {
//        $this->item->update([
//            'registry_item_id' => RegistryItem::factory()->create()->id
//        ]);
//
//
//    }

    /** @test */
    public function can_get_accessory_field()
    {
        $accessoryFieldProduct = AccessoryFieldProduct::factory()->create();

        $this->item->update([
            'accessory_field_id' => $accessoryFieldProduct->accessories_fields_id
        ]);

        $this->assertInstanceOf(AccessoryField::class, $this->item->accessoryField);
    }

    /** @test */
    public function can_get_distributor()
    {
        $this->item->update(['distributor_id' => Distributor::firstOrFactory()->id]);

        $this->assertInstanceOf(Distributor::class, $this->item->distributor);
    }

    /** @test */
    public function can_get_accessory_linked_actions_item()
    {
        CartItem::factory(2)->create([
            'accessory_link_actions' => $this->item->id
        ]);

        $linkedItems = $this->item->accessoryLinkedActionItems()->get();

        $this->assertCount(2, $linkedItems);
        $this->assertInstanceOf(CartItem::class, $linkedItems->first());
    }

    /** @test */
    public function can_get_item_discount_conditions()
    {
        CartItemDiscountCondition::factory(3)->create([
            'condition_id' => DiscountCondition::factory()
        ]);

        $this->assertCount(3, $this->item->discountConditions);
        $this->assertInstanceOf(
            CartItemDiscountCondition::class,
            $this->item->discountConditions->first()
        );
    }

    /** @test */
    public function can_get_item_discount_advantages()
    {
        CartItemDiscountAdvantage::factory(3)->create([
            'advantage_id' => DiscountAdvantage::factory()
        ]);

        $this->assertCount(3, $this->item->discountAdvantages);
        $this->assertInstanceOf(
            CartItemDiscountAdvantage::class,
            $this->item->discountAdvantages->first()
        );
    }
}
