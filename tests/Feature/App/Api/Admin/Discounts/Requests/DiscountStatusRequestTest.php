<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Requests;

use App\Api\Admin\Discounts\Requests\DiscountStatusRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class DiscountStatusRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private DiscountStatusRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new DiscountStatusRequest();
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
