<?php

namespace Tests\Feature\Traits;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Addresses\Models\Address;
use Domain\Distributors\Models\Distributor;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderNote;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Domain\Payments\Models\PaymentMethod;
use Domain\Products\Enums\ProductOptionTypes;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductType;

trait TestOrders
{
    protected string $firstName = "First";
    protected string $lastName = "Last";
    protected string $billingFirstName = "Billing1st";
    protected string $billingLastName = "Billing2nd";
    protected string $shippingFirstName = "Shipping1st";
    protected string $shippingLastName = "Shipping2nd";
    protected string $orderPhone = "012345678";
    protected string $orderNo = "012345678";
    protected string $orderEmail = "testEmail@email.com";
    protected int $countryId = 0;
    protected int $stateId = 0;
    protected int $distributorId = 0;
    protected int $statusId = 0;
    protected int $paymentMethodId = 0;
    protected int $shippingMethodId = 0;

    protected int $productTypeId = 0;

    protected function createOrders($createShipment = false)
    {
        $orders = [];
        $billingAddress1 = Address::factory()->create([
            'first_name' => $this->billingFirstName,
            'last_name' => $this->billingLastName
        ]);
        $billingAddress2 = Address::factory()->create([
            'first_name' => 'test',
            'last_name' => 'test'
        ]);

        $shippingAddress1 = Address::factory()->create([
            'first_name' => $this->shippingFirstName,
            'last_name' => $this->shippingLastName
        ]);
        $shippingAddress2 = Address::factory()->create([
            'first_name' => 'test',
            'last_name' => 'test'
        ]);

        $account1 = Account::factory()->create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName
        ]);
        $account2 = Account::factory()->create([
            'first_name' => 'test',
            'last_name' => 'test'
        ]);
        $orders[] = Order::factory()->create([
            'account_id' => $account1->id,
            'billing_address_id' => $billingAddress2->id,
            'shipping_address_id' => $shippingAddress2->id,
            'order_phone' => 'test',
            'order_email' => 'test@test.com',
        ]);

        $orders[] = Order::factory()->create([
            'account_id' => $account2->id,
            'billing_address_id' => $billingAddress1->id,
            'shipping_address_id' => $shippingAddress2->id,
            'order_phone' => 'test',
            'order_email' => 'test@test.com',

        ]);
        $orders[] = Order::factory()->create([
            'shipping_address_id' => $shippingAddress1->id,
            'account_id' => $account2->id,
            'billing_address_id' => $billingAddress2->id,
            'order_phone' => 'test',
            'order_email' => 'test@test.com',
        ]);
        $orders[] = Order::factory()->create([
            'shipping_address_id' => $shippingAddress2->id,
            'account_id' => $account2->id,
            'billing_address_id' => $billingAddress2->id,
            'order_phone' => $this->orderPhone,
            'order_email' => 'test@test.com',
        ]);
        $orders[] = Order::factory()->create([
            'shipping_address_id' => $shippingAddress2->id,
            'account_id' => $account2->id,
            'billing_address_id' => $billingAddress2->id,
            'order_phone' => 'test',
            'order_email' => $this->orderEmail,
        ]);

        $orders[] = Order::factory()->create([
            'account_id' => $account2->id,
            'billing_address_id' => $billingAddress2->id,
            'shipping_address_id' => $shippingAddress2->id,
            'order_email' => 'test@test.com',
            'order_phone' => 'test',
            'created_at' => Carbon::now()->subDays(10),
        ]);

        $orders[] = Order::factory()->create([
            'account_id' => $account2->id,
            'billing_address_id' => $billingAddress2->id,
            'shipping_address_id' => $shippingAddress2->id,
            'order_email' => 'test@test.com',
            'order_phone' => 'test',
            'order_no' => $this->orderNo
        ]);

        $this->countryId = Country::factory()->create()->id;
        $countryId = Country::factory()->create()->id;

        $this->stateId = StateProvince::factory()->create()->id;
        $stateId = StateProvince::factory()->create()->id;

        $this->distributorId = Distributor::factory()->create()->id;
        $distributorId = Distributor::factory()->create()->id;

        $this->shippingMethodId = ShippingMethod::factory()->create()->id;
        $shippingMethodId = ShippingMethod::factory()->create()->id;

        $this->paymentMethodId = PaymentMethod::factory()->create()->id;
        $paymentMethodId = PaymentMethod::factory()->create()->id;

        $this->statusId = ShipmentStatus::factory()->create()->id;
        $statusId = ShipmentStatus::factory()->create()->id;

        $shippingAddress = Address::factory()->create([
            'country_id' => $this->countryId,
            'state_id' => $stateId
        ]);

        $orders[] = Order::factory()->create([
            'account_id' => $account2->id,
            'payment_method' => $paymentMethodId,
            'billing_address_id' => $billingAddress2->id,
            'shipping_address_id' => $shippingAddress->id,
            'order_email' => 'test@test.com',
            'order_phone' => 'test',
        ]);

        $shippingAddress = Address::factory()->create([
            'country_id' => $countryId,
            'state_id' => $this->stateId
        ]);

        $orders[] = Order::factory()->create([
            'account_id' => $account2->id,
            'payment_method' => $paymentMethodId,
            'billing_address_id' => $billingAddress2->id,
            'shipping_address_id' => $shippingAddress->id,
            'order_email' => 'test@test.com',
            'order_phone' => 'test',
        ]);

        $orders[] = Order::factory()->create([
            'account_id' => $account2->id,
            'payment_method' => $this->paymentMethodId,
            'billing_address_id' => $billingAddress2->id,
            'shipping_address_id' => $shippingAddress2->id,
            'order_email' => 'test@test.com',
            'order_phone' => 'test',
        ]);
        $productTypes = ProductType::factory(4)->create();
        $this->productTypeId = $productTypes[0]->id;
        $products = Product::factory(4)->create();
        foreach($products as $key=>$product)
        {
            ProductDetail::factory()->create([
                'product_id'=>$product->id,
                'type_id'=>$productTypes[$key]->id
            ]);
            $productOption = ProductOption::factory()->create([
                'product_id' => $product->id,
                'type_id' => ProductOptionTypes::DateRange,
            ]);
            if($key == 0)
            {
                ProductOptionValue::factory()->create([
                    'option_id'=>$productOption->id,
                    'start_date'=>Carbon::now()->subDays(10),
                    'end_date'=>Carbon::now()
                ]);
            }
            if($key == 1)
            {
                ProductOptionValue::factory()->create([
                    'option_id'=>$productOption->id,
                    'start_date'=>Carbon::now()->subDays(20),
                    'end_date'=>Carbon::now()->subDays(11),
                ]);
            }
            if($key == 2)
            {
                ProductOptionValue::factory()->create([
                    'option_id'=>$productOption->id,
                    'start_date'=>Carbon::now()->subDays(10),
                    'end_date'=>Carbon::now()->subDays(8),
                ]);
            }
            if($key == 3)
            {
                ProductOptionValue::factory()->create([
                    'option_id'=>$productOption->id,
                    'start_date'=>Carbon::now()->subDays(20),
                    'end_date'=>Carbon::now()->subDays(3),
                ]);
            }
        }
        foreach ($orders as $key => $order) {
            $statusIdInsert = $statusId;
            $shippingMethodIdInsert = $shippingMethodId;
            $distributorIdInsert = $distributorId;



            if ($key < 5) {
                $statusIdInsert = $this->statusId;
            }
            if ($key < 6) {
                $shippingMethodIdInsert = $this->shippingMethodId;
            }
            if ($key < 7) {
                $distributorIdInsert = $this->distributorId;
            }
            if ($createShipment) {
                $shipment = Shipment::factory()->create([
                    'order_id' => $order->id,
                    'order_status_id' => $statusIdInsert,
                    'ship_method_id' => $shippingMethodIdInsert,
                    'distributor_id' => $distributorIdInsert,
                ]);
                OrderNote::factory()->create([
                    'order_id' => $order->id
                ]);
                $orderPackage = OrderPackage::factory()->create([
                    'shipment_id' => $shipment->id
                ]);
                if($key < 4)
                {
                    OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'package_id' => $orderPackage->id,
                        'product_id'=>$products[1]->id,
                        'parent_product_id'=>$products[0]->id,
                    ]);
                }
                else if($key >= 4 && $key < 6)
                {
                    OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'package_id' => $orderPackage->id,
                        'product_id'=>$products[0]->id,
                        'parent_product_id'=>null,
                    ]);
                }
                else if($key >= 6 && $key < 8)
                {
                    OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'package_id' => $orderPackage->id,
                        'product_id'=>$products[2]->id,
                        'parent_product_id'=>$products[1]->id,
                    ]);
                }
                else
                {
                    OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'package_id' => $orderPackage->id,
                        'product_id'=>$products[3]->id,
                        'parent_product_id'=>$products[2]->id,
                    ]);
                }

            }
        }
    }
}
