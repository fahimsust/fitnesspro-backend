<?php

namespace Tests\Feature\App\Api\Admin\ModuleTemplates\Requests;


use App\Api\Admin\ModuleTemplates\Requests\ModuleTemplateSectionRequest;
use App\Rules\IsCompositeUnique;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Modules\Models\ModuleTemplateSection;
use Domain\Sites\Models\Layout\LayoutSection;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ModuleTemplateSectionRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ModuleTemplateSectionRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ModuleTemplateSectionRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'template_id' => ['numeric', 'exists:' . ModuleTemplate::Table() . ',id', 'required'],
                'section_id' => ['numeric', 'exists:' . LayoutSection::Table() . ',id', 'required', new IsCompositeUnique(
                    ModuleTemplateSection::Table(),
                    [
                        'template_id' => $this->request->template_id,
                        'section_id' => $this->request->section_id,
                    ],
                    $this->request->id
                )],
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
