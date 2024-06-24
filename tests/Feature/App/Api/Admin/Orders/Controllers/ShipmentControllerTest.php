<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Distributors\Models\Distributor;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderActivity;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDistributor;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\TestOrders;
use function route;

class ShipmentControllerTest extends ControllerTestCase
{
    use TestOrders;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_order_shipment()
    {
        $order = Order::factory()->create();
        ShipmentStatus::factory()->create(['rank'=>0]);
        $distributor = Distributor::factory()->create();
        $this->postJson(route('admin.order.shipment.store', [$order]), ['is_downloads' => true,'distributor_id' => $distributor->id])
            ->assertCreated()
            ->assertJsonStructure([
                'id'
            ]);
        $this->assertDatabaseCount(Shipment::Table(), 1);
        $this->assertDatabaseCount(OrderActivity::Table(), 1);
    }

    /** @test */
    public function can_update_order_shipment()
    {
        $order = Order::factory()->create();
        $shipment = Shipment::factory()->create();
        $distributor = Distributor::factory()->create();
        $status = ShipmentStatus::factory()->create();
        $this->putJson(route('admin.order.shipment.update', [$order, $shipment]), ['ship_cost' => 10.10])
            ->assertCreated();

        $this->assertEquals(10.10, $shipment->refresh()->ship_cost);

        $this->putJson(route('admin.order.shipment.update', [$order, $shipment]), ['order_status_id' => $status->id])
            ->assertCreated();

        $this->assertEquals($status->id, $shipment->refresh()->order_status_id);

        $this->putJson(route('admin.order.shipment.update', [$order, $shipment]), ['distributor_id' => $distributor->id])
            ->assertCreated();

        $this->assertEquals($distributor->id, $shipment->refresh()->distributor_id);
        $this->assertDatabaseCount(OrderActivity::Table(), 3);
    }

    /** @test */
    public function can_delete_order_shipment()
    {
        $order = Order::factory()->create();
        $distributor = Distributor::factory()->create();
        $parentProduct = Product::factory()->create(['combined_stock_qty' => 6]);
        $products = Product::factory(3)->create(
            [
                'parent_product' => $parentProduct->id
            ]
        );
        foreach ($products as $product) {
            ProductDistributor::factory()->create(
                [
                    'product_id' => $product->id,
                    'distributor_id' => $distributor->id,
                    'stock_qty' => 2,
                ]
            );
        }
        $shipment = Shipment::factory()->create([
            'distributor_id' => $distributor->id
        ]);
        $orderPackage = OrderPackage::factory()->create([
            'shipment_id' => $shipment->id,
        ]);
        foreach ($products as $product) {
            OrderItem::factory()->create(
                [
                    'product_id' => $product->id,
                    'actual_product_id' => $product->id,
                    'product_qty' => 2,
                    'parent_product_id' => $parentProduct->id,
                    'order_id' => $order->id,
                    'package_id' => $orderPackage->id,
                ]
            );
        }

        $this->deleteJson(
            route('admin.order.shipment.destroy', [$order, $shipment]),
        )
            ->assertOk();

        $this->assertDatabaseCount(Shipment::Table(), 0);
        $this->assertEquals(4, ProductDistributor::first()->stock_qty);
        $this->assertEquals(12, $parentProduct->refresh()->combined_stock_qty);
        $this->assertDatabaseCount(OrderActivity::Table(), 2);
    }
}
