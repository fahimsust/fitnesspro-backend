<?php

namespace Tests\Feature\Traits;

use Database\Seeders\MessageTemplateSeeder;
use Database\Seeders\PaymentGatewaySeeder;
use Database\Seeders\PaymentMethodSeeder;
use Domain\Accounts\Models\Account;
use Domain\Addresses\Models\Address;
use Domain\Orders\Actions\Checkout\CreateUpdateOrderForCheckout;
use Domain\Orders\Enums\Checkout\CheckoutStatuses;
use Domain\Orders\Enums\Order\OrderPaymentStatuses;
use Domain\Orders\Enums\Order\OrderStatuses;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountAdvantage;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Orders\Models\Checkout\CheckoutItem;
use Domain\Orders\Models\Checkout\CheckoutPackage;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Domain\Orders\Models\Order\Order;
use Domain\Sites\Models\SiteMessageTemplate;
use Domain\Sites\Models\SitePaymentMethod;
use Illuminate\Support\Collection;
use Tests\Feature\Domain\Orders\Services\Shipping\Ups\Traits\UsesUpsApiClient;

trait TestCheckouts
{
    use TestCarts,
        UsesUpsApiClient;

    protected Checkout $checkout;

    protected CheckoutStatuses $checkoutStatus = CheckoutStatuses::Init;
    protected OrderStatuses $orderStatus = OrderStatuses::PaymentArranged;
    protected OrderPaymentStatuses $orderPaymentStatus = OrderPaymentStatuses::Paid;
    protected Collection $cartItems;
    protected Collection $packages;
    protected Collection $shipments;
    protected ?Order $order = null;

    protected function prepToStartCheckout()
    {
        $this->prepProducts();
        $this->createCartItems();
        $this->createAccount();
    }

    protected function prepToRateShipments()
    {
        $this->prepToStartCheckout();
        $this->createCheckout(null);

        $this->createDistributorService("dummy-token");
        $this->prepShippingEntities();
    }

    protected function prepToCompleteCheckout()
    {
        $this->prepToPayForCheckout();

        CreateUpdateOrderForCheckout::now($this->checkout);
        $this->checkout->order->update([
            'status' => $this->orderStatus,
            'payment_status' => $this->orderPaymentStatus,
        ]);
    }

    protected function prepToPayForCheckout()
    {
        $this->seed([
            PaymentGatewaySeeder::class,
            PaymentMethodSeeder::class,
        ]);

        $this->prepSiteMessageTemplate();

        SitePaymentMethod::factory()->create([
            'payment_method_id' => 2,
            'gateway_account_id' => null,
        ]);

        $this->prepToStartCheckout();

        $this->createCheckout();
        $this->createCheckoutItems();

        $this->shipments->each(
            fn(CheckoutShipment $shipment) => $shipment->update([
                'shipping_cost' => random_int(1, 10) . "." . random_int(10, 99)
            ])
        );
    }

    protected function createCartItems(): void
    {
        $this->cartItems = CartItem::factory(3)
            ->sequence(
                [
                    'product_id' => $this->products->first()->id,
                    'distributor_id' => $this->distributors->first()->id,
                    'qty' => rand(1, 3),
                ],
                [
                    'product_id' => $this->products->get(1)->id,
                    'distributor_id' => $this->distributors->first()->id,
                    'qty' => rand(1, 3),
                ],
            )
            ->create();

        $this->cart = Cart::first();

        CartItemDiscountAdvantage::firstOrFactory();
    }

    protected function createCheckout(?int $paymentMethodId = 2): void
    {
        $this->checkout = Checkout::factory()->create([
            'status' => $this->checkoutStatus,
            'account_id' => $this->account,
            'order_id' => $this->order,
            'cart_id' => Cart::first()->id,
            'billing_address_id' => Address::firstOrFactory(),
            'shipping_address_id' => Address::firstOrFactory(),
            'payment_method_id' => $paymentMethodId,
        ]);
    }

    protected function createCheckoutItems(): void
    {
        $this->packages = collect();

        $this->shipments = CheckoutShipment::factory(2)
            ->for($this->checkout)
            ->create()
            ->each(
                fn(CheckoutShipment $shipment) => $this->packages->push(
                    CheckoutPackage::factory()
                        ->for($shipment, 'shipment')
                        ->create()
                )
            );

        CheckoutItem::factory(3)
            ->sequence(
                [
                    'package_id' => $this->packages->first()->id,
                    'cart_item_id' => $this->cartItems->first()->id,
                    'product_id' => $this->cartItems->first()->product_id,
                    'qty' => $this->cartItems->first()->qty,
                ],
                [
                    'package_id' => $this->packages->first()->id,
                    'cart_item_id' => $this->cartItems->get(1)->id,
                    'product_id' => $this->cartItems->get(1)->product_id,
                    'qty' => $this->cartItems->get(1)->qty,
                ],
                [
                    'package_id' => $this->packages->last()->id,
                    'cart_item_id' => $this->cartItems->last()->id,
                    'product_id' => $this->cartItems->last()->product_id,
                    'qty' => $this->cartItems->last()->qty,
                ]
            )
            ->create();
    }

    protected function createOrder()
    {
        return $this->order = Order::firstOrFactory([
            'status' => $this->orderStatus,
            'payment_status' => $this->orderPaymentStatus,
        ]);
    }

    protected function createAccount()
    {
        $this->account = Account::firstOrFactory([
            'membership_status' => true
        ]);

        $this->cart->update([
            'account_id' => $this->account->id
        ]);
    }

    /**
     * @return void
     */
    protected function prepSiteMessageTemplate(): void
    {
        $this->seed(MessageTemplateSeeder::class);
        SiteMessageTemplate::firstOrFactory();
    }
}
