<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Domain\Accounts\Models\AccountSpecialty;
use Domain\Accounts\Models\AccountStatus;
use Domain\Accounts\Models\AccountType;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Accounts\Models\Specialty;
use Domain\Addresses\Models\Address;
use Domain\Discounts\Models\Advantage\AdvantageProduct;
use Domain\Distributors\Models\Distributor;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Orders\Models\Checkout\CheckoutItem;
use Domain\Orders\Models\Checkout\CheckoutItemDiscount;
use Domain\Orders\Models\Checkout\CheckoutPackage;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderNote;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Photos\Models\Photo;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accountTypes = AccountType::all();
        $accountStatus = AccountStatus::all();
        $accounts = Account::all();
        for ($i = 0; $i < 30; $i++) {
            $accounts[] = Account::factory()->create(
                [
                    'status_id' => $accountStatus[rand(0, count($accountStatus) - 1)]->id,
                    'type_id' => $accountTypes[rand(0, count($accountTypes) - 1)]->id,

                ]
            );
        }
        $orders = Order::limit(10)->orderBy('id', 'asc')->get();
        foreach ($orders as $order) {
            OrderNote::factory(30)->create(['order_id' => $order->id, "created" => Carbon::now()]);
        }

        $specialties = Specialty::all();
        $dummyImagePath = $this->uploadDummyImageToS3();
        foreach ($accounts as $account) {
            $address = Address::factory(2)->create();
            AccountAddress::factory()->create(['account_id' => $account->id, 'address_id' => $address[0]->id]);
            AccountAddress::factory()->create(['account_id' => $account->id, 'address_id' => $address[1]->id]);
            Photo::factory(2)->create(['addedby' => $account->id, 'img' => $dummyImagePath]);
            Order::factory(rand(2, 10))->create(
                [
                    'account_id' => $account->id,
                    'billing_address_id' => $address[0]->id,
                    'shipping_address_id' => $address[1]->id
                ]
            );

            Subscription::factory()->create(['account_id' => $account->id]);
            Subscription::factory()->create(['account_id' => $account->id]);
            foreach ($specialties as $specialty) {
                if ((bool) rand(0, 1))
                    AccountSpecialty::factory()->create(['account_id' => $account->id, 'specialty_id' => $specialty->id, 'approved' => (bool) rand(0, 1)]);
            }
        }
        $this->createOrderShipment();
        $this->createCheckoutShipment();
    }

    protected function createOrderShipment()
    {
        $orders = Order::limit(10)->orderBy('id', 'asc')->get();
        $distributors = Distributor::all();
        $shipmentStatus = ShipmentStatus::all();
        $products = Product::where('parent_product', null)->get();
        foreach ($orders as $order) {
            Checkout::factory()->withAddresses()->create(['account_id' => $order->account_id, 'order_id' => $order->id]);
            $shipments = Shipment::factory(rand(2, 3))->create(
                [
                    'order_id' => $order->id,
                    'distributor_id' => $distributors[0]->id,
                    'order_status_id' => $shipmentStatus[rand(0, count($shipmentStatus) - 1)]->id,
                ]
            );
            OrderTransaction::factory(rand(1, 10))->create(
                [
                    'order_id' => $order->id,
                ]
            );
            foreach ($shipments as $shipment) {
                $orderPackages = OrderPackage::factory(rand(2, 3))->create(['shipment_id' => $shipment->id]);
                foreach ($orderPackages as $orderPackage) {
                    OrderItem::factory()->create(['product_id' => $products[rand(4, count($products) - 1)]->id, 'order_id' => $order->id, 'package_id' => $orderPackage->id]);
                }
            }
        }
    }
    protected function createCheckoutShipment()
    {
        $checkouts = Checkout::all();
        $distributors = Distributor::all();
        foreach ($checkouts as $checkout) {
            $shipments = CheckoutShipment::factory(rand(2, 3))->create(
                [
                    'checkout_id' => $checkout->id,
                    'distributor_id' => $distributors[0]->id,
                ]
            );
            foreach ($shipments as $shipment) {
                $orderPackages = CheckoutPackage::factory(rand(2, 3))->create(['shipment_id' => $shipment->id]);
                foreach ($orderPackages as $orderPackage) {
                    $checkoutItem = CheckoutItem::factory()->create(['package_id' => $orderPackage->id]);
                    if (rand(1, 2) == 1) {
                        CheckoutItemDiscount::factory()->create(['checkout_item_id' => $checkoutItem->id]);
                    }
                }
            }
        }
    }
    protected function uploadDummyImageToS3()
    {
        // Assuming you have a dummy image in your local storage
        $dummyImage = new File(storage_path('dummy_image.png'));

        // Upload the image to S3 and get the path
        $filePath = Storage::disk('s3')->putFile('photos', $dummyImage, 'public');

        return $filePath;
    }
}
