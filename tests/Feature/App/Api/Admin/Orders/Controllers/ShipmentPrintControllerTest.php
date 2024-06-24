<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\TestOrders;
use function route;

class ShipmentPrintControllerTest extends ControllerTestCase
{
    use TestOrders;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }


    /** @test */
    public function can_get_shipment()
    {
        $shipment = Shipment::factory()->create();
        $package = OrderPackage::factory()->create([
            'shipment_id'=>$shipment->id,
        ]);
        OrderItem::factory(2)->create([
            'package_id'=>$package->id,
        ]);
        $this->getJson(route('admin.shipment-print.show', [$shipment->id]))
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'order' => [
                    'id',
                    'order_no',
                    'shipping_address',
                    'account'
                ],
                'packages'=>[
                    '*'=>[
                        'items'
                    ]
                ]
            ]);
    }
}
