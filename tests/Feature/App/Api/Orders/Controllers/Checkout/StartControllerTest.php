<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Checkout;

use Domain\Orders\Enums\Order\OrderPaymentStatuses;
use Domain\Orders\Enums\Order\OrderStatuses;
use Domain\Orders\Models\Checkout\Checkout;
use Tests\Feature\Traits\TestCheckouts;
use Tests\TestCase;
use function route;

class StartControllerTest extends TestCase
{
    use TestCheckouts;

    /** @test */
    public function can_create()
    {
        $this->prepToStartCheckout();

        $this->assertDatabaseCount(Checkout::Table(), 0);

        $response = $this->postJson(
            route('checkout.start'),
            [
                'cart_id' => $this->cart->id,
                'account_id' => $this->account->id,
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                'checkout' => [
                    'id',
                    'uuid',
                    'status',
                    'comments',
                    'payment_method',
                    'billing_address',
                    'shipping_address',
                    'account',
                    'cart',
                    'order',
                ]
            ]);

        $this->assertDatabaseCount(Checkout::Table(), 1);

//        dd($response->json());
    }

    /** @test */
    public function can_find()
    {
        $this->prepToStartCheckout();

        $existingCheckout = Checkout::factory()
            ->for($this->account)
            ->for($this->cart)
            ->create();

        $this->assertDatabaseCount(Checkout::Table(), 1);

        $response = $this->postJson(
            route('checkout.start'),
            [
                'cart_id' => $this->cart->id,
                'account_id' => $this->account->id,
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                'checkout' => [
                    'id',
                    'uuid',
                    'status',
                    'comments',
                    'payment_method',
                    'billing_address',
                    'shipping_address',
                    'account',
                    'cart',
                    'order',
                ]
            ]);

        $this->assertEquals(
            $existingCheckout->id,
            $response->json('checkout.id')
        );
        $this->assertDatabaseCount(Checkout::Table(), 1);

//        dd($response->json());
    }
}
