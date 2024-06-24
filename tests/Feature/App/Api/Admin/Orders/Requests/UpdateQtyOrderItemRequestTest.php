<?php

namespace Tests\Feature\App\Api\Admin\Orders\Requests;

use App\Api\Admin\Orders\Requests\UpdateQtyOrderItemRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class UpdateQtyOrderItemRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private UpdateQtyOrderItemRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new UpdateQtyOrderItemRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'product_qty' => ['int', 'required'],
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
