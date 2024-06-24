<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategorySiteSettingModuleValueSearchRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Domain\Modules\Models\Module;
use Domain\Products\Models\Category\Category;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\Site;


class CategorySiteSettingModuleValueSearchRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CategorySiteSettingModuleValueSearchRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategorySiteSettingModuleValueSearchRequest();
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
