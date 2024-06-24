<?php

namespace Tests\Feature\App\Api\Accounts\Controllers\Registration;

use App\Api\Accounts\Requests\Registration\CreateAccountAddressRequest;
use Domain\Accounts\Actions\AccountAddresses\CreateAssignDefaultBillingAddressToAccount;
use Domain\Accounts\Models\AccountAddress;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Addresses\Models\Address;
use Illuminate\Http\Response;
use Tests\TestCase;
use function route;


class RegistrationBillingAddressControllerTest extends TestCase
{
    private array $addressStructure;
    public Registration $registration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createTestAccount();
        $this->registration = Registration::factory()->create();
        $this->account = $this->registration->account;
        $this->addressStructure = [
            'id',
//            'account_id',
//            'is_billing',
//            'is_shipping',
//            'status',
//            'address_id',

            'label',
            'company',
            'first_name',
            'last_name',
            'address_1',
            'city',
            'state_id',
            'country_id',
            'postal_code',
            'email',
            'phone',
            'is_residential',
        ];
        session(['registrationId' => $this->registration->id]);
    }

    /** @test */
    public function can_show_billing_addresses()
    {
        AccountAddress::factory(5)->create([
            'is_billing' => 1,
            'address_id' => Address::factory(),
            'status' => true
        ]);

        $r = $this->getJson(route('registration.billing-address.all'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(5)
            ->assertJsonStructure(
                [
                    '*' => $this->addressStructure
                ]
            );
    }

    /** @test */
    public function can_add_default_billing_address()
    {
        CreateAccountAddressRequest::fake();

        $this->postJson(route('registration.billing-address.store'))
            ->assertCreated();

        $this->assertEquals($this->account->fresh()->default_billing_id, AccountAddress::first()->id);
    }

    /** @test */
    public function can_return_current_bill_address()
    {
        $address = AccountAddress::factory()->create(['is_billing' => 1]);
        $this->account->update([
            'default_billing_id' => $address->id
        ]);

        $this->getJson(route('registration.billing-address.show'))
            ->assertStatus(Response::HTTP_OK)->assertJsonStructure($this->addressStructure);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $data = CreateAccountAddressRequest::factory()->create(['first_name' => '']);

        $this->postJson(route('registration.billing-address.store'), $data)
            ->assertJsonValidationErrorFor('first_name')
            ->assertStatus(422);

        $this->assertDatabaseCount(AccountAddress::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateAssignDefaultBillingAddressToAccount::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        CreateAccountAddressRequest::fake();

        $this->postJson(route('registration.billing-address.store'))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertEquals(null, $this->account->fresh()->default_billing_id);
    }

    /** @test */
    public function can_update_bill_address()
    {
        $address = AccountAddress::factory()->create(['is_billing' => 1]);
        $this->account->update([
            'default_billing_id' => $address->id
        ]);
        $address_new = AccountAddress::factory()->create(['is_billing' => 1]);

        $this->putJson(route('registration.billing-address.change'), ['address_id' => $address_new->id])
            ->assertCreated();
        $this->assertEquals($address_new->id, $this->account->fresh()->default_billing_id);
    }

    /** @test */
    public function can_validate_update_request_and_return_errors()
    {
        $address = AccountAddress::factory()->create(['is_billing' => 1]);

        $this->putJson(route('registration.billing-address.change'), ['address_id' => 0])
            ->assertJsonValidationErrorFor('address_id')
            ->assertStatus(422);

        $this->assertNotEquals($address->id, $this->account->fresh()->default_billing_id);
    }
}
