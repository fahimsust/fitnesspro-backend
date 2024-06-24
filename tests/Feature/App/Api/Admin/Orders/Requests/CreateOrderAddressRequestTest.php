<?php

namespace Tests\Feature\App\Api\Admin\Orders\Requests;

use App\Api\Admin\Orders\Requests\CreateOrderAddressRequest;
use Domain\Addresses\Models\Address;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CreateOrderAddressRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CreateOrderAddressRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateOrderAddressRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'address_id' => ['numeric', 'exists:' . Address::Table() . ',id', 'required'],
                'is_billing' => ['boolean', 'required'],
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
