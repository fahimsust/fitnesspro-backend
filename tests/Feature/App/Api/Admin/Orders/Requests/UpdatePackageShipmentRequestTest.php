<?php

namespace Tests\Feature\App\Api\Admin\Orders\Requests;

use App\Api\Admin\Orders\Requests\UpdatePackageShipmentRequest;
use Domain\Orders\Models\Order\Shipments\Shipment;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class UpdatePackageShipmentRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private UpdatePackageShipmentRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new UpdatePackageShipmentRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'shipment_id' => ['int', 'exists:' . Shipment::Table() . ',id', 'required'],
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
