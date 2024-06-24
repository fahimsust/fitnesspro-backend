<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Distributors\Models\Distributor;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\TestOrders;
use function route;

class MoveOrderItemControllerTest extends ControllerTestCase
{
    use TestOrders;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_package_of_order_item()
    {
        $distributor = Distributor::factory()->create();
        $shipments = Shipment::factory(2)->create([
            'distributor_id' => $distributor->id
        ]);
        $orderPackages = OrderPackage::factory(2)->create([
            'shipment_id' => $shipments[0]->id,
        ]);
        $orderItem = OrderItem::factory()->create([
            'package_id' => $orderPackages[0]->id,
        ]);

        $this->postJson(
            route('admin.package.item.move', [$orderPackages[0], $orderItem]),
            ['package_id' => $orderPackages[1]->id]
        )
            ->assertOk();
        $this->assertEquals($orderPackages[1]->id, $orderItem->refresh()->package_id);
    }
    /** @test */
    public function can_get_exception_for_different_distributor()
    {
        $distributor = Distributor::factory()->create();
        $shipment1 = Shipment::factory()->create([
            'distributor_id' => $distributor->id
        ]);
        $distributor = Distributor::factory()->create();
        $shipment2 = Shipment::factory()->create([
            'distributor_id' => $distributor->id
        ]);
        $orderPackage = OrderPackage::factory()->create([
            'shipment_id' => $shipment1->id,
        ]);
        $orderItem = OrderItem::factory()->create([
            'package_id' => $orderPackage->id,
        ]);
        $orderPackage2 = OrderPackage::factory()->create([
            'shipment_id' => $shipment2->id,
        ]);

        $this->postJson(
            route('admin.package.item.move', [$orderPackage, $orderItem]),
            ['package_id' => $orderPackage2->id]
        )
            ->assertStatus(500);
        $this->assertEquals($orderPackage->id, $orderItem->refresh()->package_id);
    }
}
