<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategorySiteSettingsRequest;
use App\Rules\IsCompositeUnique;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Domain\Products\Models\Category\CategorySiteSettings;
use Domain\Sites\Models\Site;
use Illuminate\Validation\Rule;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CategorySiteSettingsRequestTest extends ControllerTestCase
{
    use AdditionalAssertions;

    private CategorySiteSettingsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategorySiteSettingsRequest();
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
                    new IsCompositeUnique(
                        CategorySiteSettings::Table(),
                        [
                            'site_id' => $this->request->site_id,
                            'category_id' => $this->request->category_id,
                        ],
                        $this->request->id
                    ),
                ],
                'settings_template_id' => [
                    'int',
                    'exists:' . CategorySettingsTemplate::Table() . ',id',
                    Rule::requiredIf(fn () => ($this->request->settings_template_id_default == 1)),
                    'nullable',
                ],
                'settings_template_id_default' => [
                    'int',
                    'nullable',
                ],
                'module_template_id' => [
                    'int',
                    'exists:' . ModuleTemplate::Table() . ',id',
                    Rule::requiredIf(fn () => ($this->request->module_template_id_default == 1)),
                    'nullable',
                ],
                'module_template_id_default' => [
                    'int',
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
