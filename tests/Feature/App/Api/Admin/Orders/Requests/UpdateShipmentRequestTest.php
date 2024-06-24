<?php

namespace Tests\Feature\App\Api\Admin\Orders\Requests;

use App\Api\Admin\Orders\Requests\UpdateShipmentRequest;
use Domain\Distributors\Models\Distributor;
use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class UpdateShipmentRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private UpdateShipmentRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new UpdateShipmentRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'ship_cost' => ['numeric', 'nullable'],
                'order_status_id' => ['int', 'exists:' . ShipmentStatus::Table() . ',id', 'nullable'],
                'distributor_id' => ['int', 'exists:' . Distributor::Table() . ',id', 'nullable']
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
