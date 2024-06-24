<?php

namespace Tests\Feature\App\Api\Admin\ModuleTemplates\Requests;


use App\Api\Admin\ModuleTemplates\Requests\ModuleTemplateRequest;
use Domain\Modules\Models\ModuleTemplate;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ModuleTemplateRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ModuleTemplateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ModuleTemplateRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string', 'max:100', 'required'],
                'parent_template_id' => ['numeric', 'exists:' . ModuleTemplate::Table() . ',id', 'nullable'],
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
