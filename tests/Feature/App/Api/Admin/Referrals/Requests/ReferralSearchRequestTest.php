<?php

namespace Tests\Feature\App\Api\Admin\Referrals\Requests;

use App\Api\Admin\Referrals\Requests\ReferralSearchRequest;
use Domain\Affiliates\Models\ReferralStatus;
use Domain\Orders\Models\Order\Order;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ReferralSearchRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ReferralSearchRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ReferralSearchRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'status_id' => ['numeric', 'exists:' . ReferralStatus::Table() . ',id', 'nullable'],
                'order_id' => ['numeric', 'exists:' . Order::Table() . ',id', 'nullable'],
                'keyword' => ['string', 'nullable'],
                'name' => ['string', 'nullable'],
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
