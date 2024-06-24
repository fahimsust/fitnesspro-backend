<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Requests;

use App\Api\Admin\CustomForms\Requests\CreateSectionFieldRequest;
use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\FormSection;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CreateSectionFieldRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CreateSectionFieldRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateSectionFieldRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'field_id' => ['numeric', 'exists:' . CustomField::Table() . ',id', 'required'],
                'section_id' => ['numeric', 'exists:' . FormSection::Table() . ',id', 'required'],
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
