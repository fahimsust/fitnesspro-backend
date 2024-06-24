<?php

namespace Tests\Feature\App\Api\Admin\Orders\Requests;

use App\Api\Admin\Orders\Requests\OrderItemsRequest;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Illuminate\Validation\Rule;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class OrderItemsRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private OrderItemsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new OrderItemsRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'items' => [
                    'array',
                    'required',
                ],
                'items.*' => [
                    'int',
                    Rule::exists(OrderItem::Table(), 'id'),
                ]
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
