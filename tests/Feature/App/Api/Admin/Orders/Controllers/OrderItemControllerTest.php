<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Orders\Dtos\OptionCustomValuesData;
use Domain\Orders\Models\Order\OrderActivity;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemOption;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDistributor;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\TestOrders;
use function route;

class OrderItemControllerTest extends ControllerTestCase
{
    use TestOrders;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();

        SiteSettings::factory()
            ->for(
                Site::firstOrFactory(['id' => config('site.id')])
            )
            ->create();
    }

    /** @test */
    public function can_create_order_item_and_item_option()
    {
        $product = Product::factory()->create();
        $shipment = Shipment::factory()->create();
        $orderPackage = OrderPackage::factory()
            ->for($shipment)
            ->create();

        ProductDistributor::factory()
            ->create([
                'product_id' => $product->id,
                'distributor_id' => $shipment->distributor_id
            ]);

        ProductPricing::factory()->create();

        $productOptions = ProductOption::factory(2)
            ->create((['product_id' => $product->id, 'type_id' => 1]));
        $productOptionValues = ProductOptionValue::factory(2)
            ->sequence(
                ['option_id' => $productOptions->first()->id],
                ['option_id' => $productOptions->last()->id]
            )
            ->create();

        $optionCustomValuesData1 = new OptionCustomValuesData(
            $productOptionValues->first()->id,
            'custom text dummy value'
        );
        $optionCustomValuesData2 = new OptionCustomValuesData(
            $productOptionValues->last()->id,
        );

        $requestData = [
            'child_product_id' => $product->id,
            'package_id' => $orderPackage->id,
            'qty' => 1,
            'option_custom_values' => [
                $optionCustomValuesData1->toArray(),
                $optionCustomValuesData2->toArray(),
            ]
        ];

        $this->postJson(route('admin.package.item.store', [$orderPackage]), $requestData)
            ->assertCreated();
        $this->assertDatabaseCount(OrderItem::Table(), 1);
        $this->assertDatabaseCount(OrderItemOption::Table(), 2);

        $orderItems = OrderItem::all();
        $this->assertDatabaseHas(
            OrderItemOption::Table(),
            ['item_id' => $orderItems->first()->id,]
            + $optionCustomValuesData1->toArray()
        );
        $this->assertDatabaseHas(
            OrderItemOption::Table(),
            ['item_id' => $orderItems->last()->id,]
            + $optionCustomValuesData2->toArray()
        );
    }

    /** @test */
    public function can_delete_order_item()
    {
        $package = OrderPackage::factory()->create();
        $orderItem = OrderItem::factory()->create(['package_id' => $package->id]);
        OrderItemOption::factory()->create(['item_id' => $orderItem->id]);

        $this->deleteJson(route('admin.package.item.destroy', [$package, $orderItem]))
            ->assertOk();

        $this->assertDatabaseCount(OrderItem::Table(), 0);
        $this->assertDatabaseCount(OrderItemOption::Table(), 0);
        $this->assertDatabaseCount(OrderActivity::Table(), 1);
    }
    /** @test */
    public function can_delete_order_items()
    {
        $package = OrderPackage::factory()->create();
        $orderItems = OrderItem::factory(5)->create(['package_id' => $package->id]);

        foreach ($orderItems as $orderItem)
            OrderItemOption::factory()->create(['item_id' => $orderItem->id]);

        $this->postJson(
            route('admin.package.delete-items', [$package]),
            [
                'items' => $orderItems->pluck('id')->toArray()
            ]
        )
            ->assertOk();

        $this->assertDatabaseCount(OrderItem::Table(), 0);
        $this->assertDatabaseCount(OrderItemOption::Table(), 0);
        $this->assertDatabaseCount(OrderActivity::Table(), 5);
    }

    /** @test */
    public function can_update_package_item_quantity()
    {
        $package = OrderPackage::factory()->create();
        $orderItem = OrderItem::factory()->create(['package_id' => $package->id, 'product_qty' => 1]);

        $this->putJson(route('admin.package.item.update', [$package, $orderItem]), [
            'product_qty' => 3
        ])
            ->assertOk();
        $this->assertEquals(3, $orderItem->refresh()->product_qty);
    }
}
