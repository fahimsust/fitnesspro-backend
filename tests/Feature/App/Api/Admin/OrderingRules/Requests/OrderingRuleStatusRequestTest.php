<?php

namespace Tests\Feature\App\Api\Admin\OrderingRules\Requests;

use App\Api\Admin\Elements\Requests\ElementStatusRequest;
use App\Api\Admin\OrderingRules\Requests\OrderingRuleStatusRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class OrderingRuleStatusRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private OrderingRuleStatusRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new OrderingRuleStatusRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'status' => ['bool', 'required'],
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
