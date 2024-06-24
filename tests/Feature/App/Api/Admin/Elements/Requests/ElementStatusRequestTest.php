<?php

namespace Tests\Feature\App\Api\Admin\Elements\Requests;

use App\Api\Admin\Elements\Requests\ElementStatusRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ElementStatusRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ElementStatusRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ElementStatusRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'status' => ['bool', 'required'],
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
