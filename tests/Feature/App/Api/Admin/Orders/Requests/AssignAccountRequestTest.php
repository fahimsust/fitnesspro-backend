<?php

namespace Tests\Feature\App\Api\Admin\Orders\Requests;

use App\Api\Admin\Orders\Requests\AssignAccountRequest;
use Domain\Accounts\Models\Account;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class AssignAccountRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private AssignAccountRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AssignAccountRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'account_id' => ['int', 'exists:' . Account::Table() . ',id', 'required'],
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
