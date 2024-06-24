<?php

namespace Tests\Feature\App\Api\Admin\Accounts\Controllers;

use App\Api\Accounts\Requests\Registration\CreateAccountAddressRequest;
use App\Api\Admin\Accounts\Requests\AccountAddressRequest;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Domain\Addresses\Models\Address;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AccountAddressControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_list_account_address()
    {
        $account = Account::factory()->create();
        $addresses = Address::factory(5)->create();
        foreach ($addresses as $address) {
            AccountAddress::factory()->create(['account_id' => $account->id, 'address_id' => $address->id]);
        }
        $this->getJson(route('admin.account-address.index', ['account_id' => $account->id]))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'is_billing',
                    'is_shipping',
                    'status',
                    'address' => [
                        'first_name',
                        'last_name',
                        'address_1'
                    ]
                ]
            ])
            ->assertJsonCount(5);
    }


    /** @test */
    public function can_update_Account_address()
    {
        $account = Account::factory()->create();
        $address = Address::factory()->create();
        $accountAddress = AccountAddress::factory()->create(['account_id' => $account->id, 'address_id' => $address->id]);
        AccountAddressRequest::fake(['first_name' => 'test', 'is_default_address' => 1, 'is_billing' => true, 'last_name' => 'test', 'is_shipping' => false]);

        $this->putJson(route('admin.account-address.update', [$accountAddress]))
            ->assertCreated();

        $this->assertEquals('test', $address->refresh()->first_name);
        $this->assertEquals('test', $address->refresh()->last_name);
        $this->assertTrue($accountAddress->refresh()->is_billing);
        $this->assertFalse($accountAddress->refresh()->is_shipping);
        $this->assertEquals($accountAddress->id, $account->refresh()->default_billing_id);
    }
    /** @test */
    public function can_create_account_address()
    {
        CreateAccountAddressRequest::fake(['is_shipping' => true]);

        $this->postJson(route('admin.account-address.store'))
            ->assertCreated();

        $this->assertDatabaseCount(AccountAddress::Table(), 1);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $account = Account::factory()->create();
        $address = Address::factory()->create();
        $accountAddress = AccountAddress::factory()->create(['account_id' => $account->id, 'address_id' => $address->id]);
        AccountAddressRequest::fake(['first_name' => 'test', 'is_billing' => false, 'last_name' => 'test', 'is_shipping' => false]);

        $this->putJson(route('admin.account-address.update', [$accountAddress]))
            ->assertJsonValidationErrorFor('is_shipping')
            ->assertStatus(422);
    }
}
