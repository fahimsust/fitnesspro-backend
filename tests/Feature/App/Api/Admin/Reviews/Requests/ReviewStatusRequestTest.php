<?php

namespace Tests\Feature\App\Api\Admin\Reviews\Requests;

use App\Api\Admin\Reviews\Requests\ReviewApprovalRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ReviewStatusRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ReviewApprovalRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ReviewApprovalRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'approved' => ['bool', 'required'],
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
