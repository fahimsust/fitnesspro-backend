<?php

namespace Tests\Feature\App\Api\Admin\Pages\Requests;

use App\Api\Admin\Pages\Requests\PageStatusRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class PageStatusRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private PageStatusRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new PageStatusRequest();
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
