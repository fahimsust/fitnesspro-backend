<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Requests;

use App\Api\Admin\Discounts\Requests\DiscountRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class DiscountRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private DiscountRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new DiscountRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string', 'max:85', 'required'],
                'display' => ['string', 'max:85', 'required'],
                'start_date' => ['nullable','date'],
                'exp_date' => ['nullable','date'],
                'limit_uses' => ['integer', 'nullable'],
                'limit_per_order' => ['integer', 'nullable'],
                'limit_per_customer' => ['integer', 'nullable']
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
