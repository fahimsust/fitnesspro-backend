<?php

namespace Tests\Feature\App\Api\Accounts\Requests\Registration;

use App\Api\Accounts\Requests\Registration\AccountAddressIdRequest;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Illuminate\Http\Response;
use JMac\Testing\Traits\AdditionalAssertions;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;


class AccountAddressIdRequestTest extends TestCase
{
    use AdditionalAssertions;

    private AccountAddressIdRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AccountAddressIdRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'address_id' => ['integer','required','exists:'.AccountAddress::table().',id']
            ],
            $this->request->rules()
        );
    }

    /** @test */
    public function can_authorize()
    {
        $this->assertTrue($this->request->authorize());
    }

    /** @test */
    public function can_handle_address_exception()
    {
        $address = AccountAddress::factory()->create(['is_billing' => 1]);
        $newAccount = Account::factory()->create();

        $this->putJson(route('registration.billing-address.change', $newAccount),
            ['address_id' => $address->id]
        )
            ->assertJsonFragment(['exception' => NotFoundHttpException::class])
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertNotEquals($address->id, $newAccount->fresh()->default_billing_id);
    }

}
