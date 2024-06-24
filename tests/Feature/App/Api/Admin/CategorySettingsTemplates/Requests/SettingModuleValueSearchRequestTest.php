<?php

namespace Tests\Feature\App\Api\Admin\CategorySettingsTemplates\Requests;

use App\Api\Admin\CategorySettingsTemplates\Requests\SettingModuleValueSearchRequest;
use Domain\Modules\Models\Module;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Domain\Sites\Models\Layout\LayoutSection;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class SettingModuleValueSearchRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private SettingModuleValueSearchRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new SettingModuleValueSearchRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'settings_template_id' => [
                    'int',
                    'exists:' . CategorySettingsTemplate::Table() . ',id',
                    'required',
                ],
                'module_id' => [
                    'int',
                    'exists:' . Module::Table() . ',id',
                    'required',
                ],
                'section_id' => [
                    'int',
                    'exists:' . LayoutSection::Table() . ',id',
                    'required',
                ],
    
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
