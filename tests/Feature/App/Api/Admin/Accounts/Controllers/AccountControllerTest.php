<?php

namespace Tests\Feature\App\Api\Admin\Accounts\Controllers;

use App\Api\Admin\Accounts\Requests\AccountRequest;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Domain\Accounts\Models\AccountStatus;
use Domain\Accounts\Models\AccountType;
use Domain\Addresses\Models\Address;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Support\Facades\Hash;
use function route;

class AccountControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_list_account()
    {
        Account::factory(5)->create();
        $this->getJson(route('admin.accounts.index'))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'created_at'
                ]
            ]])
            ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function can_search_account_by_keyword()
    {
        Account::factory(5)->create(['first_name' => 'Matched']);
        Account::factory(5)->create(['first_name' => 'Not']);
        $this->getJson(
            route('admin.accounts.index', ['keyword' => 'Matched'])
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'created_at'
                ]
            ]])
            ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function can_search_account_by_first_name()
    {
        Account::factory(5)->create(['first_name' => 'Matched']);
        Account::factory(5)->create(['first_name' => 'Not']);
        $this->getJson(
            route('admin.accounts.index', ['first_name' => 'Matched']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'created_at'
                ]
            ]])
            ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function can_search_account_by_last_name()
    {
        Account::factory(5)->create(['last_name' => 'Matched']);
        Account::factory(5)->create(['last_name' => 'Not']);
        $this->getJson(
            route('admin.accounts.index', ['last_name' => 'Matched']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'created_at'
                ]
            ]])
            ->assertJsonCount(5, 'data');
    }
    /** @test */
    public function can_search_account_by_type()
    {
        $types = AccountType::factory(5)->create();
        Account::factory(5)->create(['type_id' => $types[0]->id]);
        Account::factory(5)->create(['type_id' => $types[1]->id]);
        $this->getJson(
            route('admin.accounts.index', ['type_id' => $types[0]->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'created_at'
                ]
            ]])
            ->assertJsonCount(5, 'data');
    }
    /** @test */
    public function can_search_account_by_status()
    {
        $status = AccountStatus::factory(5)->create();
        Account::factory(5)->create(['status_id' => $status[0]->id]);
        Account::factory(5)->create(['status_id' => $status[1]->id]);
        $this->getJson(
            route('admin.accounts.index', ['status_id' => $status[0]->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'created_at'
                ]
            ]])
            ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function can_search_account_by_city_country_state()
    {
        $address = Address::factory(2)->create();
        $account_address = AccountAddress::factory()->create(['address_id' => $address[0]->id]);
        $account_address2 = AccountAddress::factory()->create(['address_id' => $address[1]->id]);
        Account::factory(5)->create(['default_billing_id' => $account_address->id]);
        Account::factory(5)->create(['default_billing_id' => $account_address2->id]);
        $this->getJson(
            route('admin.accounts.index', [
                'city' => $address[0]->city,
                'country_id' => $address[0]->country_id,
                'state_id' => $address[0]->state_id
            ]),

        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'created_at'
                ]
            ]])
            ->assertJsonCount(5, 'data');
    }
    /** @test */
    public function can_update_Account()
    {
        $account = Account::factory()->create();
        AccountRequest::fake(['first_name' => 'test', 'password' => '123456']);

        $this->putJson(route('admin.accounts.update', [$account]))
            ->assertCreated();

        $this->assertEquals('test', $account->refresh()->first_name);
        $this->assertTrue(Hash::check('123456', $account->refresh()->password));

        AccountRequest::fake(['last_name' => 'test2', 'password' => null]);

        $this->putJson(route('admin.accounts.update', [$account]))
            ->assertCreated();

        $this->assertEquals('test2', $account->refresh()->last_name);
        $this->assertTrue(Hash::check('123456', $account->refresh()->password));
    }
}
