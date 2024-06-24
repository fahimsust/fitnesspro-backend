<?php

namespace Tests\Feature\App\Api\Admin\Orders\Requests;

use App\Api\Admin\Orders\Requests\CreateShipmentRequest;
use Domain\Distributors\Models\Distributor;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CreateShipmentRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CreateShipmentRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateShipmentRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'is_downloads' => ['boolean', 'required'],
                'distributor_id' => ['int', 'exists:' . Distributor::Table() . ',id', 'required']
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
