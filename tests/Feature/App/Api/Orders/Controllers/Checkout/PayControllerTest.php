<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Checkout;

use Database\Seeders\PaymentGatewaySeeder;
use Database\Seeders\PaymentMethodSeeder;
use Domain\Orders\Enums\Order\OrderPaymentStatuses;
use Domain\Orders\Enums\Order\OrderStatuses;
use Domain\Sites\Models\SitePaymentMethod;
use Tests\Feature\Traits\TestCheckouts;
use Tests\TestCase;
use function route;

class PayControllerTest extends TestCase
{
    use TestCheckouts;

    /** @test */
    public function can()
    {
//        $this->withoutExceptionHandling();
        $this->orderStatus = OrderStatuses::Recorded;
        $this->orderPaymentStatus = OrderPaymentStatuses::Pending;

        $this->prepToPayForCheckout();

        $response = $this->postJson(
            route('checkout.pay', $this->checkout->uuid),
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
            ->assertCreated()
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
            OrderPaymentStatuses::InTransit->label(),
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
