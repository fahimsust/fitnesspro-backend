<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductSiteSettingsRequest;
use App\Rules\IsCompositeUnique;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplate;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\Layout;
use Domain\Sites\Models\Site;
use Illuminate\Validation\Rule;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductSiteSettingsRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductSiteSettingsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductSiteSettingsRequest();
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
                        ProductSiteSettings::Table(),
                        [
                            'site_id' => $this->request->site_id,
                            'product_id' => $this->request->product_id
                        ],
                        $this->request->id
                    )
                ],
                'settings_template_id' => [
                    'int',
                    'exists:' . ProductSettingsTemplate::Table() . ',id',
                    Rule::requiredIf(fn () => ($this->request->settings_template_id_default == 1)),
                    'nullable',
                ],
                'layout_id' => [
                    'int',
                    'exists:' . Layout::Table() . ',id',
                    Rule::requiredIf(fn () => ($this->request->layout_id_default == 1)),
                    'nullable',
                ],
                'module_template_id' => [
                    'int',
                    'exists:' . ModuleTemplate::Table() . ',id',
                    Rule::requiredIf(fn () => ($this->request->module_template_id_default == 1)),
                    'nullable',
                ],
                'product_detail_template' => [
                    'int',
                    Rule::exists(DisplayTemplate::Table(),'id')->where(function($query) {
                        $query->where('type_id',config('display_templates.product_detail'));
                    }),
                    Rule::requiredIf(fn () => ($this->request->product_detail_template_default == 1)),
                    'nullable',
                ],
                'product_thumbnail_template' => [
                    'int',
                     Rule::exists(DisplayTemplate::Table(),'id')->where(function($query) {
                        $query->where('type_id',config('display_templates.product_thumbnail'));
                     }),
                     Rule::requiredIf(fn () => ($this->request->product_thumbnail_template_default == 1)),
                    'nullable',
                ],
                'product_zoom_template' => [
                    'int',
                     Rule::exists(DisplayTemplate::Table(),'id')->where(function($query) {
                        $query->where('type_id',config('display_templates.product_zoom'));
                     }),
                     Rule::requiredIf(fn () => ($this->request->product_zoom_template_default == 1)),
                     'nullable',
                ],
                'settings_template_id_default' => [
                    'int',
                    'nullable',
                ],
                'layout_id_default' => [
                    'int',
                    'nullable',
                ],
                'module_template_id_default' => [
                    'int',
                    'nullable',
                ],
                'product_detail_template_default' => [
                    'int',
                    'nullable',
                ],
                'product_thumbnail_template_default' => [
                    'int',
                    'nullable',
                ],
                'product_zoom_template_default' => [
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
