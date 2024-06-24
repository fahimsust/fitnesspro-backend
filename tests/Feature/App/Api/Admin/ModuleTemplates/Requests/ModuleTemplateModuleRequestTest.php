<?php

namespace Tests\Feature\App\Api\Admin\ModuleTemplates\Requests;

use App\Api\Admin\ModuleTemplates\Requests\ModuleTemplateModuleRequest;
use App\Rules\IsCompositeUnique;
use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Modules\Models\ModuleTemplateModule;
use Domain\Sites\Models\Layout\LayoutSection;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ModuleTemplateModuleRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ModuleTemplateModuleRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ModuleTemplateModuleRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'template_id' => ['numeric', 'exists:' . ModuleTemplate::Table() . ',id', 'required'],
                'section_id' => ['numeric', 'exists:' . LayoutSection::Table() . ',id', 'required'],
                'module_id' => ['numeric', 'exists:' . Module::Table() . ',id', 'required', new IsCompositeUnique(
                    ModuleTemplateModule::Table(),
                    [
                        'template_id' => $this->request->template_id,
                        'section_id' => $this->request->section_id,
                        'module_id' => $this->request->module_id,
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
