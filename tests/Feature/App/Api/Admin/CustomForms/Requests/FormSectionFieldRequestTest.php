<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Requests;

use App\Api\Admin\CustomForms\Requests\FormSectionFieldRequest;
use Domain\CustomForms\Models\FormSection;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class FormSectionFieldRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private FormSectionFieldRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new FormSectionFieldRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string','max:255', 'required'],
                'display' => ['string','max:255', 'required'],
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
