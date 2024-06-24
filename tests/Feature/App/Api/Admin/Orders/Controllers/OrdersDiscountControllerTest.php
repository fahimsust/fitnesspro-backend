<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Discounts\Enums\DiscountAdvantageTypes;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Actions\Order\Discount\ApplyDiscountToOrder;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderActivity;
use Domain\Orders\Models\Order\OrderDiscount;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\TestOrders;
use function route;

class OrdersDiscountControllerTest extends ControllerTestCase
{
    use TestOrders;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function it_can_add_amount_of_discount_to_order()
    {
        $order = Order::factory()->create();
        $discount = Discount::factory()->create();
        DiscountAdvantage::factory()->create([
            'advantage_type_id' => DiscountAdvantageTypes::AMOUNT_OFF_ORDER,
            'discount_id' => $discount->id,
            'amount' => 10
        ]);
        $this->postJson(route('admin.order.discount.store', [$order]), [
            'discount_id' => $discount->id,
        ])->assertOk();

        $this->assertDatabaseHas(OrderDiscount::Table(), [
            'order_id' => $order->id,
            'discount_id' => $discount->id,
            'amount' => '10'
        ]);
        $this->assertDatabaseCount(OrderActivity::Table(), 1);
    }
    /** @test */
    public function it_can_add_percentage_of_discount_to_order()
    {
        $order = Order::factory()->create();
        $discount = Discount::factory()->create();
        DiscountAdvantage::factory()->create([
            'advantage_type_id' => DiscountAdvantageTypes::PERCENTAGE_OFF_ORDER,
            'discount_id' => $discount->id,
            'amount' => 10
        ]);
        $this->postJson(route('admin.order.discount.store', [$order]), [
            'discount_id' => $discount->id,
        ])->assertOk();

        $this->assertDatabaseHas(OrderDiscount::Table(), [
            'order_id' => $order->id,
            'discount_id' => $discount->id,
            'amount' => '%10'
        ]);
        $this->assertDatabaseCount(OrderActivity::Table(), 1);
    }
    /** @test */
    public function it_cant_add_discount_to_order()
    {
        $order = Order::factory()->create();
        $discount = Discount::factory()->create();
        DiscountAdvantage::factory()->create([
            'advantage_type_id' => DiscountAdvantageTypes::PERCENTAGE_OFF_ORDER,
            'discount_id' => $discount->id,
            'amount' => 10
        ]);
        $this->postJson(route('admin.order.discount.store', [$order]), [
            'discount_id' => $discount->id,
        ])->assertOk();

        $this->assertDatabaseCount(OrderDiscount::Table(), 1);
    }
    /** @test */
    public function it_can_add_discount_and_delete_discount_from_order()
    {
        $order = Order::factory()->create();
        $discount = Discount::factory()->create();
        DiscountAdvantage::factory(3)->create([
            'advantage_type_id' => DiscountAdvantageTypes::AMOUNT_OFF_ORDER,
            'discount_id' => $discount->id,
        ]);
        DiscountAdvantage::factory(2)->create([
            'advantage_type_id' => DiscountAdvantageTypes::PERCENTAGE_OFF_ORDER,
            'discount_id' => $discount->id,
        ]);
        DiscountAdvantage::factory(3)->create([
            'advantage_type_id' => DiscountAdvantageTypes::PERCENTAGE_OFF_PRODUCT,
            'discount_id' => $discount->id,
        ]);
        ApplyDiscountToOrder::now($order, $discount);
        $this->assertDatabaseCount(OrderDiscount::Table(), 5);
        $this->deleteJson(route('admin.order.discount.destroy', [$order, $discount]));
        $this->assertDatabaseCount(OrderDiscount::Table(), 0);
    }
}
