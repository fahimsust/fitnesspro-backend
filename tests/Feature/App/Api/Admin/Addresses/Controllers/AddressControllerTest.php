<?php

namespace Tests\Feature\App\Api\Admin\Addresses\Controllers;

use App\Api\Admin\Addresses\Requests\CreateAddressRequest;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Domain\Addresses\Actions\CreateAddressFromAddressData;
use Domain\Addresses\Models\Address;
use Domain\Affiliates\Models\Affiliate;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AddressControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_address()
    {
        CreateAddressRequest::fake();

        $this->postJson(route('admin.address.store'))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(Address::Table(), 1);
    }

    /** @test */
    public function can_update_address()
    {
        $address = Address::factory()->create();
        CreateAddressRequest::fake(['label' => 'test']);

        $this->putJson(route('admin.address.update', [$address]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals('test', $address->refresh()->label);
    }
     /** @test */
     public function can_show_address()
     {
         $address = Address::factory()->create();

        $response =  $this->getJson(route('admin.address.show', [$address]))
             ->assertOk()
             ->assertJsonStructure(['id','state_province']);
     }

    /** @test */
    public function can_search_address()
    {
        $address = Address::factory(10)->create(['label' => 'test1']);
        $address2 = Address::factory(10)->create(['label' => 'not_match']);
        $account = Account::factory()->create();
        AccountAddress::factory()->create(['address_id' => $address[0]->id]);
        AccountAddress::factory()->create(['address_id' => $address[1]->id]);
        AccountAddress::factory()->create(['address_id' => $address[2]->id]);
        AccountAddress::factory()->create(['address_id' => $address2[2]->id]);


        $this->getJson(
            route('admin.address.index',['keyword' => 'test', 'account_id' => $account->id]),
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'label',
                    'email'
                ]
            ])->assertJsonCount(3);

        $this->getJson(
            route('admin.address.index',['keyword' => 'test']),
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'label',
                    'email'
                ]
            ])->assertJsonCount(7);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $data = CreateAddressRequest::factory()->create(['first_name' => '']);

        $this->postJson(route('admin.address.store'), $data)
            ->assertJsonValidationErrorFor('first_name')
            ->assertStatus(422);

        $this->assertDatabaseCount(Affiliate::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateAddressFromAddressData::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        CreateAddressRequest::fake();

        $this->postJson(route('admin.address.store'))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(Address::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CreateAddressRequest::fake();

        $this->postJson(route('admin.address.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(Address::Table(), 0);
    }
}
