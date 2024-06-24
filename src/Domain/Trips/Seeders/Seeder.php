<?php

namespace Domain\Trips\Seeders;

use Domain\Accounts\Models\Account;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\Region;
use Domain\Locales\Models\StateProvince;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemOptionOld;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Domain\Products\Enums\ProductOptionTypes;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductType;
use Domain\Resorts\Models\Resort;
use Domain\Sites\Models\Site;

class Seeder
{
    public $start_date;

    public $end_date;

    public $date_format;

    public int $order_status_id;

    /**
     * @var Account|null
     */
    private ?Account $account;

    public function __construct(?Account $account = null)
    {
        $this->account = $account;

        $this->order_status_id = ShipmentStatus::whereName('Confirmed')->first()->id; //10;
        $this->date_format = 'Y-m-d';
    }

    public function startDate($date)
    {
        $this->start_date = $date;

        return $this;
    }

    public function endDate($date)
    {
        $this->end_date = $date;

        return $this;
    }

    public function orderStatus($statusId)
    {
        $this->order_status_id = $statusId;

        return $this;
    }

    public function create()
    {
        $site = Site::firstOrFactory();

        $product = Product::factory()->create();
        $productOption = ProductOption::factory()->create([
            'product_id' => $product->id,
            'type_id' => ProductOptionTypes::DateRange,
        ]);

        $productOptionValue = ProductOptionValue::factory()->create([
            'option_id' => $productOption->id,
            'start_date' => $this->start_date->format($this->date_format),
            'end_date' => $this->end_date->format($this->date_format),
        ]);

        $attribute = Attribute::find(config('trips.resort_attribute_id'))
            ?? Attribute::factory(['id' => config('trips.resort_attribute_id')])->create(); //factory()->create();
        $attributeOption = AttributeOption::firstOrFactory([
            'attribute_id' => $attribute->id,
        ]); //factory()->create();
        $productAttribute = ProductAttribute::firstOrFactory([
            'product_id' => $product->id,
            'option_id' => $attributeOption->id,
        ]); //factory()->create();

        Country::firstOrFactory(['name' => 'Test Country']);
        StateProvince::firstOrFactory(['name' => 'Test State']);
        Region::firstOrFactory(['name' => 'Test Region']);
        $resort = Resort::firstOrFactory(['attribute_option_id' => $attributeOption->id, 'description' => 'Test Resort'])->create();
        //        dd($attribute, $attributeOption);

        $data = $this->account ? ['account_id' => $this->account->id] : [];
        $order = Order::factory()->create(
            [
                'site_id' => $site->id,
            ] + $data
        );

        $shipment = Shipment::factory()->create([
            'order_id' => $order->id,
            'order_status_id' => $this->order_status_id,
        ]);

        $orderPackage = OrderPackage::factory()->create([
            'shipment_id' => $shipment->id,
        ]);

        $orderProduct = OrderItem::factory()->create([
            'package_id' => $orderPackage->id,
            'order_id' => $order->id,
        ]);

        //        $productType = ProductType::factory()->create(['id' => config('trips.vacation_type_id')]);
        $productDetail = ProductDetail::firstOrFactory([
            'type_id' => ProductType::firstOrFactory(['id' => config('trips.vacation_type_id')]),
            'product_id' => $product->id,
        ]);
        $orderProductOption = OrderItemOptionOld::factory()->create([
            'orders_products_id' => $orderProduct->id,
            'value_id' => $productOptionValue->id,
        ]);

        //        dump([
        //            'site' => $site->id,
        //            'account' => $this->account->id,
        //            'product' => $product->id,
        //            'productOptionType' => $productOptionType->id,
        //            'productOption' => $productOption->id,
        //            'productOptionValue' => $productOptionValue->id,
        //            'attribute' => $attribute->id,
        //            'attributeOption' => $attributeOption->id,
        ////            'productDetail' => $prod
        //        ]);
    }
}
