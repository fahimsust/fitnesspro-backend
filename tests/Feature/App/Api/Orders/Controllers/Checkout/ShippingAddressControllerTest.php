<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Checkout;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Domain\Addresses\Models\Address;
use Domain\Orders\Exceptions\AccountNotAllowedCheckoutException;
use Domain\Orders\Models\Checkout\Checkout;
use Tests\Feature\Traits\TestCheckouts;
use Tests\TestCase;
use function route;

class ShippingAddressControllerTest extends TestCase
{
    use TestCheckouts;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prepToStartCheckout();

        $this->checkout = Checkout::factory()
            ->for($this->account)
            ->for($this->cart)
            ->create();
    }

    /** @test */
    public function can()
    {
        $this->assertNull($this->checkout->shipping_address_id);

        $address = Address::factory()->create();

        AccountAddress::factory()
            ->for($this->account)
            ->for($address)
            ->create([
                'is_shipping' => true
            ]);

        $response = $this->postJson(
            route(
                'checkout.shipping-address',
                $this->checkout->uuid
            ),
            [
                'address_id' => $address->id,
                'set_as_billing' => false
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                'address'
            ]);

        $this->assertEquals(
            $this->checkout->fresh()->shipping_address_id,
            $address->id
        );
        $this->assertEquals(
            $address->id,
            $response->json('address.id')
        );

//        dd($response->json());
    }

    /** @test */
    public function can_set_as_billing()
    {
        $this->assertNull($this->checkout->shipping_address_id);
        $this->assertNull($this->checkout->billing_address_id);

        $address = Address::factory()->create();

        AccountAddress::factory()
            ->for($this->account)
            ->for($address)
            ->create([
                'is_shipping' => true,
                'is_billing' => true
            ]);

        $response = $this->postJson(
            route(
                'checkout.shipping-address',
                $this->checkout->uuid
            ),
            [
                'address_id' => $address->id,
                'set_as_billing' => true
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                'address'
            ]);

        $checkoutFresh = $this->checkout->fresh();
        $this->assertEquals(
            $checkoutFresh->shipping_address_id,
            $address->id
        );
        $this->assertEquals(
            $checkoutFresh->billing_address_id,
            $address->id
        );
        $this->assertEquals(
            $address->id,
            $response->json('address.id')
        );

//        dd($response->json());
    }

    /** @test */
    public function can_error()
    {
        $address = Address::factory()
            ->create();

        $response = $this->postJson(
            route(
                'checkout.shipping-address',
                $this->checkout->uuid
            ),
            [
                'address_id' => $address->id,
                'set_as_billing' => false
            ]
        )
            ->assertNotFound()
            ->assertJsonFragment([
                'message' => __("Address does not belong to account.")
            ]);

//        dd($response->json());
    }
}
