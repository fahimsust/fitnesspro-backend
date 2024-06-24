<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Checkout;

use Domain\Accounts\Models\AccountAddress;
use Domain\Addresses\Models\Address;
use Domain\Orders\Models\Checkout\Checkout;
use Tests\Feature\Traits\TestCheckouts;
use Tests\TestCase;
use function route;

class BillingAddressControllerTest extends TestCase
{
    use TestCheckouts;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prepToPayForCheckout();

        $this->checkout = Checkout::factory()
            ->for($this->account)
            ->for($this->cart)
            ->create();
    }

    /** @test */
    public function can()
    {
        $this->assertNull($this->checkout->billing_address_id);

        $address = Address::factory()->create();

        AccountAddress::factory()
            ->for($this->account)
            ->for($address)
            ->create([
                'is_billing' => true
            ]);

        $response = $this->postJson(
            route(
                'checkout.billing-address',
                $this->checkout->uuid
            ),
            [
                'address_id' => $address->id,
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                'address'
            ]);

        $this->assertEquals(
            $this->checkout->fresh()->billing_address_id,
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
                'checkout.billing-address',
                $this->checkout->uuid
            ),
            [
                'address_id' => $address->id,
            ]
        )
            ->assertNotFound()
            ->assertJsonFragment([
                'message' => __("Address does not belong to account.")
            ]);

//        dd($response->json());
    }
}
