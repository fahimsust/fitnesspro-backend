<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Distributors\Models\Distributor;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderActivity;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDistributor;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\TestOrders;
use function route;

class OrderPackageControllerTest extends ControllerTestCase
{
    use TestOrders;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_order_shipment_package()
    {
        $shipment = Shipment::factory()->create();
        $this->postJson(route('admin.shipment.order-package.store', [$shipment]))
            ->assertCreated()
            ->assertJsonStructure([
                'id'
            ]);
        $this->assertDatabaseCount(OrderPackage::Table(), 1);
        $this->assertDatabaseCount(OrderActivity::Table(), 1);
    }

    /** @test */
    public function can_delete_order_shipment_package()
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
            route('admin.shipment.order-package.destroy', [$shipment, $orderPackage]),
        )
            ->assertOk();
        $this->assertDatabaseCount(OrderPackage::Table(), 0);
        $this->assertEquals(4, ProductDistributor::first()->stock_qty);
        $this->assertEquals(12, $parentProduct->refresh()->combined_stock_qty);
        $this->assertDatabaseCount(OrderActivity::Table(), 1);
    }

    /** @test */
    public function can_update_shipment_of_package()
    {
        $distributor = Distributor::factory()->create();
        $shipments = Shipment::factory(2)->create([
            'distributor_id' => $distributor->id
        ]);
        $orderPackage = OrderPackage::factory()->create([
            'shipment_id' => $shipments[0]->id,
        ]);

        $this->putJson(
            route('admin.shipment.order-package.update', [$shipments[0], $orderPackage]),
            ['shipment_id' => $shipments[1]->id]
        )
            ->assertOk();
        $this->assertEquals($shipments[1]->id, $orderPackage->refresh()->shipment_id);
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

        $this->putJson(
            route('admin.shipment.order-package.update', [$shipment1, $orderPackage]),
            ['shipment_id' => $shipment2->id]
        )
            ->assertStatus(500);
        $this->assertEquals($shipment1->id, $orderPackage->refresh()->shipment_id);
    }
}
