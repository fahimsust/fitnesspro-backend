<?php

namespace Tests\Feature\App\Api\Admin\Orders\Requests;

use App\Api\Admin\Orders\Requests\MoveOrderItemRequest;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class MoveOrderItemRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private MoveOrderItemRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new MoveOrderItemRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'package_id' => ['int', 'exists:' . OrderPackage::Table() . ',id', 'required'],
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
