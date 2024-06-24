<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategorySiteSettingModuleValueRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Products\Models\Category\Category;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\Site;


class CategorySiteSettingModuleValueRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CategorySiteSettingModuleValueRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategorySiteSettingModuleValueRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'site_id' => [
                    'int',
                    'exists:' . Site::Table() . ',id',
                    'nullable',
                ],
                'category_id' => [
                    'int',
                    'exists:' . Category::Table() . ',id',
                    'required',
                ],
                'module_id' => [
                    'int',
                    'exists:' . Module::Table() . ',id',
                    'required',
                ],
                'field_id' => [
                    'int',
                    'exists:' . ModuleField::Table() . ',id',
                    'required',
                ],
                'section_id' => [
                    'int',
                    'exists:' . LayoutSection::Table() . ',id',
                    'required',
                ],
                'custom_value' => [
                    'string',
                    'nullable',
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
