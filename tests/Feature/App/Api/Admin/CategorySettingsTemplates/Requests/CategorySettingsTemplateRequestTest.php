<?php

namespace Tests\Feature\App\Api\Admin\CategorySettingsTemplates\Requests;

use App\Api\Admin\CategorySettingsTemplates\Requests\CategorySettingsTemplateRequest;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\SearchForm\SearchForm;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\Layout;
use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Validation\Rule;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CategorySettingsTemplateRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CategorySettingsTemplateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategorySettingsTemplateRequest();
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
                'layout_id_default' => [
                    'int',
                    'nullable',
                ],
                'module_template_id_default' => [
                    'int',
                    'nullable',
                ],
                'category_thumbnail_template' => [
                    'int',
                     Rule::exists(DisplayTemplate::Table(),'id')->where(function($query) {
                        $query->where('type_id',config('display_templates.category_thumbnail'));
                     }),
                    'nullable',
                ],
    
                'feature_thumbnail_template' => [
                    'int',
                     Rule::exists(DisplayTemplate::Table(),'id')->where(function($query) {
                        $query->where('type_id',config('display_templates.product_thumbnail'));
                     }),
                    'nullable',
                ],
                'product_thumbnail_template' => [
                    'int',
                     Rule::exists(DisplayTemplate::Table(),'id')->where(function($query) {
                        $query->where('type_id',config('display_templates.product_thumbnail'));
                     }),
                    'nullable',
                ],
                'show_categories_in_body' => [
                    'numeric',
                    'nullable',
                ],
                'show_featured' => [
                    'numeric',
                    'nullable',
                ],
                'feature_defaultsort' => [
                    'numeric',
                    'nullable',
                ],
                'feature_showsort' => [
                    'numeric',
                    'nullable',
                ],
                'feature_showmessage' => [
                    'numeric',
                    'nullable',
                ],
                'feature_thumbnail_count' => [
                    'int',
                    'nullable',
                ],
                'show_products' => [
                    'numeric',
                    'nullable',
                ],
                'product_thumbnail_showsort' => [
                    'numeric',
                    'nullable',
                ],
                'product_thumbnail_defaultsort' => [
                    'numeric',
                    'nullable',
                ],
                'product_thumbnail_count' => [
                    'int',
                    'nullable',
                ],
                'product_thumbnail_showmessage' => [
                    'numeric',
                    'nullable',
                ],
                'search_form_id' => [
                    'int',
                    'exists:' . SearchForm::Table() . ',id',
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
