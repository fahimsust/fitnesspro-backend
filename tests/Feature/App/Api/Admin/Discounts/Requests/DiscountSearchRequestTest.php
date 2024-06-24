<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Requests;

use App\Api\Admin\Discounts\Requests\DiscountSearchRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class DiscountSearchRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private DiscountSearchRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new DiscountSearchRequest();
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
