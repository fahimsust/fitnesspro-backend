<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Requests;

use App\Api\Admin\CustomForms\Requests\FormSectionFieldUpdateRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class FormSectionFieldUpdateRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private FormSectionFieldUpdateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new FormSectionFieldUpdateRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'rank' => ['int', 'nullable'],
                'required' => ['bool', 'nullable'],
                'new_row' => ['bool', 'nullable'],
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
