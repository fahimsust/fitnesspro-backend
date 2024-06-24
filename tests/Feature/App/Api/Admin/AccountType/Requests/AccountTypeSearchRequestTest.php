<?php

namespace Tests\Feature\App\Api\Admin\AccountType\Requests;

use App\Api\Admin\AccountType\Requests\AccountTypeSearchRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class AccountTypeSearchRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private AccountTypeSearchRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AccountTypeSearchRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'keyword' => ['string', 'nullable'],
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
