<?php

namespace Tests\Feature\App\Api\Admin\Affiliates\Requests;

use App\Api\Admin\Affiliates\Requests\AffiliateSearchRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class AffiliateSearchRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private AffiliateSearchRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AffiliateSearchRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'keyword' => ['string', 'nullable'],
                'status' => ['boolean','nullable'],
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
