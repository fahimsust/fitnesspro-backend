<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Checkout;

use Database\Seeders\MessageTemplateSeeder;
use Domain\Accounts\Models\Account;
use Domain\Addresses\Models\Address;
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
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Models\SiteMessageTemplate;
use Tests\Feature\Traits\TestCarts;
use Tests\Feature\Traits\TestCheckouts;
use Tests\TestCase;
use function route;

class CompleteControllerTest extends TestCase
{
    use TestCheckouts;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prepToCompleteCheckout();
    }

    /** @test */
    public function can()
    {
        $response = $this->putJson(
            route('checkout.complete', $this->checkout->uuid),
            [
                'include_shipments' => true,
                'include_payment_method' => true,
                'include_billing_address' => true,
                'include_shipping_address' => true,
                'item_relations' => [
                    'discounts',
                    'product',
                ]
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                'order' => [
                    'id',
                    'number',
                    'payment_status',
                    'status',
                    'phone',
                    'email',
                    'payment_method_fee',
                    'addtl_fee',
                    'addtl_discount',
                    'account',
                    'affiliate',
                    'billing_address',
                    'shipping_address',
                    'payment_method',
                    'discounts',
                    'notes',
                    'site',
                    'transactions',
                    'shipments',
                ]
            ]);

        $this->assertEquals(
            OrderStatuses::Completed->label(),
            $response->json('order.status')
        );
        $this->assertEquals(
            OrderPaymentStatuses::Paid->label(),
            $response->json('order.payment_status')
        );

        $this->assertCount(
            2,
            $response->json('order.shipments')
        );
        $this->assertCount(
            2,
            $response->json('order.shipments.0.packages.0.items')
        );

//        dd($response->json());
    }
}
