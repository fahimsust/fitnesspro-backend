<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Requests;

use App\Api\Admin\CustomForms\Requests\CustomFieldOptionRequest;
use Domain\CustomForms\Models\CustomField;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CustomFieldOptionRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CustomFieldOptionRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CustomFieldOptionRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'display' => ['string','max:255', 'required'],
                'value' => ['string','max:255', 'required'],
                'rank' => ['int', 'nullable'],
                'field_id' => ['numeric', 'exists:' . CustomField::Table() . ',id', 'required'],
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
