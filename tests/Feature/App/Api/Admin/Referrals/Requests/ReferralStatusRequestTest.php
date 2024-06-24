<?php

namespace Tests\Feature\App\Api\Admin\Referrals\Requests;

use App\Api\Admin\Referrals\Requests\ReferralStatusRequest;
use Domain\Affiliates\Models\ReferralStatus;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ReferralStatusRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ReferralStatusRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ReferralStatusRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'status_id' => ['numeric', 'exists:' . ReferralStatus::Table() . ',id', 'required'],
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
