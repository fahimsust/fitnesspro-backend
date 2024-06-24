<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Addresses\Models\Address;
use Domain\Orders\Models\Order\Order;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderAddressControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_update_order_shipping_and_billing_address()
    {
        $previousAddress = Address::factory()->create();
        $order = Order::factory()->create([
            'billing_address_id' => $previousAddress->id,
            'shipping_address_id' => $previousAddress->id
        ]);
        $newAddress = Address::factory()->create();
        $this->postJson(route('admin.order.address', $order), ['address_id' => $newAddress->id, 'is_billing' => true])
            ->assertCreated();

        $this->assertEquals($newAddress->id, $order->refresh()->billing_address_id);
        $this->postJson(route('admin.order.address', $order), ['address_id' => $newAddress->id, 'is_billing' => false])
            ->assertCreated();

        $this->assertEquals($newAddress->id, $order->refresh()->shipping_address_id);
    }
}
