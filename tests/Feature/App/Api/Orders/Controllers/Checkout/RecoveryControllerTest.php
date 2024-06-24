<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Checkout;

use Tests\Feature\Traits\TestCheckouts;
use Tests\TestCase;
use function route;

class RecoveryControllerTest extends TestCase
{
    use TestCheckouts;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prepToPayForCheckout();
    }

    /** @test */
    public function can()
    {
        $response = $this->postJson(
            route(
                'checkout.show',
                $this->checkout->uuid
            ),
            [
                'include_shipments' => true,
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                'checkout' => [
                    'id',
                    'uuid',
                    'status',
                    'comments',
                    'account',
                    'order',
                    'affiliate',
                    'cart' => [
                        'items'
                    ],
                    'billing_address',
                    'shipping_address',
                    'payment_method',
                    'shipments' => [
                        '*' => [
                            'shipping_method',
                            'shipping_cost',
                            'packages' => [
                                '*' => [
                                    'items' => [
                                        '*' => [
                                            'cart_item' => [
                                                'product'
                                            ],
                                            'qty',
                                            'discounts'
                                        ]
                                    ]
                                ]
                            ],
                        ]
                    ],
                    'subtotal',
                    'tax_total',
                    'shipping_total',
                    'discount_total',
                    'total',
                ]
            ]);

//        dd($response->json());
    }

    /** @test */
    public function can_error()
    {
        $response = $this->postJson(
            route(
                'checkout.show',
                "dummy-uuid"
            ),
        )
            ->assertNotFound();

//        dd($response->json());
    }
}
