<?php

namespace Tests\Feature\App\Api\Admin\ProductSettingsTemplates\Requests;

use App\Api\Admin\ProductSettingsTemplates\Requests\ProductSettingsTemplateRequest;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\Layout;
use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Validation\Rule;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductSettingsTemplateRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductSettingsTemplateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductSettingsTemplateRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string','max:55', 'required'],
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
