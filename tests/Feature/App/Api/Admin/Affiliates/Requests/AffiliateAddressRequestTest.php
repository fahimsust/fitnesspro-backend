<?php

namespace Tests\Feature\App\Api\Admin\Affiliates\Requests;

use App\Api\Admin\Affiliates\Requests\AffiliateAddressRequest;
use Domain\Addresses\Models\Address;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class AffiliateAddressRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private AffiliateAddressRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AffiliateAddressRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'address_id' => ['numeric', 'exists:' . Address::Table() . ',id', 'required'],
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
