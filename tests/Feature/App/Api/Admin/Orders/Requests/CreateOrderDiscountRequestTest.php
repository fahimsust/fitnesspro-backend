<?php

namespace Tests\Feature\App\Api\Admin\Orders\Requests;

use App\Api\Admin\Orders\Requests\CreateOrderDiscountRequest;
use Domain\Discounts\Models\Discount;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CreateOrderDiscountRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CreateOrderDiscountRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateOrderDiscountRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'discount_id' => ['int', 'exists:' . Discount::Table() . ',id', 'required'],
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
