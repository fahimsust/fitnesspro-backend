<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Checkout;

use Domain\Orders\Actions\Checkout\CompleteOrderForCheckout;
use Tests\Feature\Traits\TestCheckouts;
use Tests\TestCase;
use function route;

class OrderControllerTest extends TestCase
{
    use TestCheckouts;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function can()
    {
        $this->prepToCompleteCheckout();
        CompleteOrderForCheckout::now($this->checkout);

        $response = $this->postJson(
            route(
                'checkout.order',
                $this->checkout->uuid
            ),
            [
                'include_account' => true,
                'include_affiliate' => true,
                'include_billing_address' => true,
                'include_shipping_address' => true,
                'include_payment_method' => true,
                'include_discounts' => true,
                'include_notes' => true,
                'include_transactions' => true,
                'include_shipments' => true,
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
                    'comments',
                    'payment_method_fee',
                    'addtl_fee',
                    'addtl_discount',
                    'account' => [
                        'id',
                    ],
                    'affiliate',
                    'billing_address',
                    'shipping_address',
                    'payment_method',
                    'discounts',
                    'notes',
                    'transactions',
                    'shipments',
                ]
            ]);
    }

    /** @test */
    public function can_error_if_order_not_set()
    {
        $this->prepToPayForCheckout();

        $response = $this->postJson(
            route(
                'checkout.order',
                $this->checkout->uuid
            )
        )
            ->assertNotFound()
            ->assertJsonFragment([
                'message' => 'Order not found',
            ]);

//        dd($response->json());
    }

    /** @test */
    public function can_error()
    {
        $this->prepToCompleteCheckout();

        $response = $this->postJson(
            route(
                'checkout.order',
                "dummy-uuid"
            ),
        )
            ->assertNotFound();

//        dd($response->json());
    }
}
