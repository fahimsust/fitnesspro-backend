<?php

namespace Tests\Unit\Domain\Orders\Jobs;

use Domain\Discounts\Models\Discount;
use Domain\Orders\Actions\Order\CompleteOrder;
use Domain\Orders\Collections\OrderShipmentDtosCollection;
use Domain\Orders\Dtos\OrderShipmentDto;
use Domain\Orders\Enums\Order\OrderStatuses;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderDiscount;
use Illuminate\Support\Facades\Event;

use Tests\TestCase;

class OrderCompletedTest extends TestCase
{

    /** @test */
    public function it_updates_discount_uses_and_deletes_discount_if_limit_reached()
    {
        Event::fake();

        $discount = Discount::factory()->create([
            'limit_uses' => 1,
        ]);
        $order = Order::factory()->create(
            [
                'status' => OrderStatuses::PaymentArranged->value
            ]
        );
        Order::factory()->create(
            [
                'status' => OrderStatuses::Recorded->value
            ]
        );
        OrderDiscount::factory()->create(
            [
                'order_id' => $order->id,
                'discount_id' => $discount->id,
            ]
        );
        $checkoutShipment = CheckoutShipment::factory()->create(['is_digital' => false, 'is_drop_ship' => true]);
        $orderShipmentDto = OrderShipmentDto::fromCheckoutShipmentModel($checkoutShipment);
        $orderShipmentDto->order($order);
        $shipments = new OrderShipmentDtosCollection([
            $orderShipmentDto
        ]);
        CompleteOrder::now($order, 100, $shipments);
        $this->assertSoftDeleted(Discount::class, ['id' => $discount->id]);
    }
}
