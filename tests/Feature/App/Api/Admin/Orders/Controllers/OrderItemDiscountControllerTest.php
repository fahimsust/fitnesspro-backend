<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Discounts\Enums\DiscountAdvantageTypes;
use Domain\Discounts\Models\Advantage\AdvantageProduct;
use Domain\Discounts\Models\Advantage\AdvantageProductType;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderActivity;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemDiscount;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductType;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderItemDiscountControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function it_can_add_amount_of_discount_to_order_item_product()
    {
        $product = Product::factory()->create();
        $order = Order::factory()->create();
        $discount = Discount::factory()->create();
        $orderItem = OrderItem::factory()->create([
            'product_id' => $product->id,
            'actual_product_id' => $product->id,
        ]);
        $advantage = DiscountAdvantage::factory()->create([
            'advantage_type_id' => DiscountAdvantageTypes::AMOUNT_OFF_PRODUCT,
            'discount_id' => $discount->id,
            'amount' => 10
        ]);
        AdvantageProduct::factory()->create(['product_id' => $product->id, 'advantage_id' => $advantage->id]);

        $this->postJson(route('admin.discount.item.store', [$discount]), [
            'items' => [$orderItem->id],
        ])->assertOk();

        $this->assertDatabaseHas(OrderItemDiscount::Table(), [
            'advantage_id' => $advantage->id,
            'discount_id' => $discount->id,
            'orders_products_id' => $orderItem->id,
            'amount' => '10'
        ]);
        $this->assertDatabaseCount(OrderActivity::Table(), 1);
    }

    /** @test */
    public function it_can_add_percentage_of_discount_to_order_item_product()
    {
        $product = Product::factory()->create();
        $order = Order::factory()->create();
        $discount = Discount::factory()->create();
        $orderItem = OrderItem::factory()->create([
            'product_id' => $product->id,
            'actual_product_id' => $product->id,
        ]);
        $advantage = DiscountAdvantage::factory()->create([
            'advantage_type_id' => DiscountAdvantageTypes::PERCENTAGE_OFF_PRODUCT,
            'discount_id' => $discount->id,
            'amount' => 10
        ]);
        AdvantageProduct::factory()->create(['product_id' => $product->id, 'advantage_id' => $advantage->id]);

        $this->postJson(route('admin.discount.item.store', [$discount]), [
            'items' => [$orderItem->id],
        ])->assertOk();

        $this->assertDatabaseHas(OrderItemDiscount::Table(), [
            'advantage_id' => $advantage->id,
            'discount_id' => $discount->id,
            'orders_products_id' => $orderItem->id,
            'amount' => '%10'
        ]);
        $this->assertDatabaseCount(OrderActivity::Table(), 1);
    }

    /** @test */
    public function it_can_add_amount_of_discount_to_order_item_product_type()
    {
        $parent = Product::factory()->create();
        $productType = ProductType::factory()->create();
        $product = Product::factory()->create([
            'parent_product' => $parent->id
        ]);
        $order = Order::factory()->create();
        $discount = Discount::factory()->create();
        $orderItem = OrderItem::factory()->create([
            'product_id' => $product->id,
            'actual_product_id' => $product->id,
            'parent_product_id' => $parent->id
        ]);

        ProductDetail::factory()->create([
            'product_id' => $parent->id,
            'type_id' => $productType->id
        ]);
        $advantage = DiscountAdvantage::factory()->create([
            'advantage_type_id' => DiscountAdvantageTypes::AMOUNT_OFF_PRODUCT_OF_TYPE,
            'discount_id' => $discount->id,
            'amount' => 10
        ]);
        AdvantageProductType::factory()->create(['producttype_id' => $productType->id,]);

        $this->postJson(route('admin.discount.item.store', [$discount]), [
            'items' => [$orderItem->id],
        ])->assertOk();

        $this->assertDatabaseHas(OrderItemDiscount::Table(), [
            'advantage_id' => $advantage->id,
            'discount_id' => $discount->id,
            'orders_products_id' => $orderItem->id,
            'amount' => '10'
        ]);
        $this->assertDatabaseCount(OrderActivity::Table(), 1);
    }

    /** @test */
    public function it_cant_add_discount_to_order_item()
    {
        $parent = Product::factory()->create();
        $productType = ProductType::factory()->create();
        $product = Product::factory()->create([
            'parent_product' => $parent->id
        ]);
        $order = Order::factory()->create();
        $discount = Discount::factory()->create();
        $orderItem = OrderItem::factory()->create([
            'product_id' => $product->id,
            'actual_product_id' => $product->id,
            'parent_product_id' => $parent->id
        ]);

        ProductDetail::factory()->create([
            'product_id' => $parent->id,
            'type_id' => $productType->id
        ]);
        $discountAdvantage = DiscountAdvantage::factory()->create([
            'advantage_type_id' => DiscountAdvantageTypes::AMOUNT_OFF_PRODUCT,
            'discount_id' => $discount->id,
            'amount' => 10
        ]);
        AdvantageProductType::factory()->create([
            'producttype_id' => $productType->id,
            'advantage_id' => $discountAdvantage->id
        ]);

        $this->postJson(route('admin.discount.item.store', [$discount]), [
            'items' => [$orderItem->id],
        ])->assertStatus(500);

        $this->assertDatabaseCount(OrderItemDiscount::Table(), 0);
    }

    /** @test */
    public function it_can_add_discount_and_delete_discount_from_order_item()
    {
        $discount = Discount::factory()->create();
        $orderItem = OrderItem::factory()->create();
        OrderItemDiscount::factory()->create([
            'orders_products_id' => $orderItem->id,
            'discount_id' => $discount->id,
        ]);
        $this->assertDatabaseCount(OrderItemDiscount::Table(), 1);
        $this->deleteJson(route('admin.discount.item.destroy', [$discount, $orderItem]));
        $this->assertDatabaseCount(OrderItemDiscount::Table(), 0);
    }
}
