<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Requests;

use App\Api\Admin\CustomForms\Requests\CustomFormRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CustomFormRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CustomFormRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CustomFormRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string','max:100', 'required'],
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
