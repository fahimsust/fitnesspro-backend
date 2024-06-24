<?php

namespace Tests\Feature\App\Api\Admin\Addresses\Requests;

use App\Api\Admin\Addresses\Requests\AddressSearchRequest;
use Domain\Accounts\Models\Account;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class AddressSearchRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private AddressSearchRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AddressSearchRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'account_id' => ['numeric', 'exists:' . Account::Table() . ',id', 'nullable'],
                'keyword' => ['string', 'required'],
            ],
            $this->request->rules()
        );
    }

    /** @test */
    public function can_authorize()
    {
        $this->createAndAuthAdminUser();

        $this->assertTrue($this->request->authorize());
    }
}
