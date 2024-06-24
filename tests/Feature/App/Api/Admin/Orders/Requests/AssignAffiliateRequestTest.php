<?php

namespace Tests\Feature\App\Api\Admin\Orders\Requests;

use App\Api\Admin\Orders\Requests\AssignAffiliateRequest;
use Domain\Affiliates\Models\Affiliate;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class AssignAffiliateRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private AssignAffiliateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AssignAffiliateRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'affiliate_id' => ['int', 'exists:' . Affiliate::Table() . ',id', 'required'],
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
