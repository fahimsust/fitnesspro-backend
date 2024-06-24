<?php

namespace Tests\Feature\App\Api\Admin\ProductSettingsTemplates\Requests;

use App\Api\Admin\ProductSettingsTemplates\Requests\ProductTemplateSettingModuleValueSearchRequest;
use Domain\Modules\Models\Module;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplate;
use Domain\Sites\Models\Layout\LayoutSection;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductTemplateSettingModuleValueSearchRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductTemplateSettingModuleValueSearchRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductTemplateSettingModuleValueSearchRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'settings_template_id' => [
                    'int',
                    'exists:' . ProductSettingsTemplate::Table() . ',id',
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
