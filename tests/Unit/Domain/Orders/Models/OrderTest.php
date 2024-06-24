<?php

namespace Tests\Unit\Domain\Orders\Models;

use Domain\Addresses\Models\Address;
use Domain\Orders\Models\Order\Order;
use Tests\TestCase;

class OrderTest extends TestCase
{


    private Order $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->order = Order::factory()->create(['order_no' => 'test-order-no']);
    }

    /** @test */
    public function can_seed()
    {
        $this->assertEquals('test-order-no', $this->order->order_no);
    }

    /** @test */
    public function can_get_billing_address()
    {
        $this->assertInstanceOf(Address::class, $this->order->billingAddress);
    }

    /** @test */
    public function can_get_shipping_address()
    {
        $this->assertInstanceOf(Address::class, $this->order->shippingAddress);
    }
}
