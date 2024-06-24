<?php

namespace Tests\Unit\Domain\Accounts\Models;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Domain\Addresses\Models\Address;
use Domain\Photos\Models\PhotoAlbum;
use Support\Helpers\Query;
use Tests\UnitTestCase;

class AccountTest extends UnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->account = Account::factory()->create(['email' => 'test@test.com']);
    }

    /** @test */
    public function can_seed()
    {
        $this->assertEquals('test@test.com', $this->account->email);
    }

    /** @test */
    public function can_get_album()
    {
        PhotoAlbum::factory()->create([
            'type' => 1,
            'type_id' => Account::factory()->create()->id,
        ]);

        $album = PhotoAlbum::factory()->create();
        $accountAlbum = $this->account->album;

        $this->assertEquals($accountAlbum->id, $album->id);
    }

    /** @test */
    public function can_get_billing_addresses()
    {
        AccountAddress::factory()->create([
            'account_id' => $this->account->id,
            'address_id' => Address::factory()->create()->id,
            'is_billing' => true,
            'status' => false
        ]);

        AccountAddress::factory()->create([
            'account_id' => $this->account->id,
            'address_id' => Address::factory()->create()->id,
            'is_billing' => false,
            'is_shipping' => true,
            'status' => true
        ]);

        $billings = collect();
        Address::factory(3)->create()->each(
            fn(Address $address) => $billings->push(
                AccountAddress::factory()->create([
                    'account_id' => $this->account->id,
                    'address_id' => $address->id,
                    'is_billing' => true,
                    'status' => true
                ])
            )
        );

        $this->assertCount(3, $this->account->billingAddresses);
        $this->assertInstanceOf(
            Address::class,
            $this->account->billingAddresses->first()
        );
        $this->assertEquals(
            $billings->pluck('address.id')->toArray(),
            $this->account->billingAddresses->pluck('id')->toArray()
        );
    }

    /** @test */
    public function can_get_default_billing_address()
    {
        $billing = AccountAddress::factory([
            'address_id' => Address::factory()->create(),
            'is_billing' => true
        ])->create();

        $shipping = AccountAddress::factory([
            'address_id' => Address::factory()->create(),
            'is_shipping' => true,
            'is_billing' => false
        ])->create();

        $this->account->update([
            'default_billing_id' => $billing->id,
            'default_shipping_id' => $shipping->id
        ]);

        $defaultBilling = $this->account->defaultBillingAddress;
        $this->assertInstanceOf(Address::class, $defaultBilling);
        $this->assertEquals($billing->address->id, $defaultBilling->id);
        $this->assertEquals($billing->id, $defaultBilling->laravel_through_key);
    }

    /** @test */
    public function can_get_shipping_addresses()
    {
        AccountAddress::factory()->create([
            'account_id' => $this->account->id,
            'address_id' => Address::factory()->create()->id,
            'is_shipping' => true,
            'status' => false
        ]);

        AccountAddress::factory()->create([
            'account_id' => $this->account->id,
            'address_id' => Address::factory()->create()->id,
            'is_billing' => true,
            'is_shipping' => false,
            'status' => true
        ]);

        $shippings = collect();
        Address::factory(3)->create()->each(
            fn(Address $address) => $shippings->push(
                AccountAddress::factory()->create([
                    'account_id' => $this->account->id,
                    'address_id' => $address->id,
                    'is_shipping' => true,
                    'status' => true
                ])
            )
        );

        $this->assertCount(3, $this->account->shippingAddresses);
        $this->assertInstanceOf(
            Address::class,
            $this->account->shippingAddresses->first()
        );
        $this->assertEquals(
            $shippings->pluck('address.id')->toArray(),
            $this->account->shippingAddresses->pluck('id')->toArray()
        );
    }

    /** @test */
    public function can_get_default_shipping_address()
    {
        $shipping = AccountAddress::factory([
            'address_id' => Address::factory()->create(),
            'is_shipping' => 1
        ])->create();

        $this->account->update([
            'default_shipping_id' => $shipping->id
        ]);

        $defaultShipping = $this->account->defaultShippingAddress;
        $this->assertInstanceOf(Address::class, $defaultShipping);
        $this->assertEquals($shipping->address->id, $defaultShipping->id);
        $this->assertEquals($shipping->id, $defaultShipping->laravel_through_key);
    }
}
