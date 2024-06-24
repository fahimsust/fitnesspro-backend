<?php

namespace Tests\Feature\App\Api\Admin\AccessoryField\Requests;

use App\Api\Admin\AccessoryField\Requests\AccessoryFieldSearchRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class AccessoryFieldSearchRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private AccessoryFieldSearchRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AccessoryFieldSearchRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'keyword' => ['string', 'nullable'],
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
