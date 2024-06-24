<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Requests;

use App\Api\Admin\CustomForms\Requests\FormSectionRequest;
use Domain\CustomForms\Models\CustomForm;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class FormSectionRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private FormSectionRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new FormSectionRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'title' => ['string','max:155', 'required'],
                'rank' => ['int', 'required'],
                'form_id' => ['numeric', 'exists:' . CustomForm::Table() . ',id', 'required'],
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
