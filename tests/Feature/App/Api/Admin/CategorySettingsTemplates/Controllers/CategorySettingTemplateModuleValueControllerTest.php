<?php

namespace Tests\Feature\App\Api\Admin\CategorySettingsTemplates\Controllers;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Domain\Products\Models\Category\CategorySettingsTemplateModuleValue;
use Domain\Sites\Models\Layout\LayoutSection;
use Illuminate\Database\Eloquent\Collection;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategorySettingTemplateModuleValueControllerTest extends ControllerTestCase
{
    private CategorySettingsTemplate $categorySettingsTemplate;
    private LayoutSection $section;
    private Module $module;
    private Collection $moduleFields;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->categorySettingsTemplate = CategorySettingsTemplate::factory()->create();
        $this->section = LayoutSection::factory()->create(['rank' => 1]);
        $this->module = Module::factory()->create();
        $this->moduleFields = ModuleField::factory(5)->create();

    }

    /** @test */
    public function can_get_category_template_module_section()
    {
        CategorySettingsTemplateModuleValue::factory()->create(
            [
                'field_id' => $this->moduleFields[0]->id,
                'custom_value' => 'first'
            ]
        );
        CategorySettingsTemplateModuleValue::factory()->create(
            [
                'field_id' => $this->moduleFields[1]->id,
                'custom_value' => 'second'
            ]
        );
        $result = $this->getJson(route('admin.category-settings-template-module-value.index', [
            'settings_template_id' => $this->categorySettingsTemplate->id,
            'module_id' => $this->module->id,
            'section_id' => $this->section->id,
        ]))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'field',
                    'custom_value',
                ]
            ])->assertJsonCount(5);
        $this->assertEquals('first', $result[0]['custom_value']);
        $this->assertEquals('second', $result[1]['custom_value']);
        $this->assertEquals('',$result[2]['custom_value']);
    }
    /** @test */
    public function can_add_category_template_setting_module_value()
    {
        $this->postJson(route('admin.category-settings-template-module-value.store'),
            [
                'settings_template_id' => $this->categorySettingsTemplate->id,
                'module_id' => $this->module->id,
                'section_id' => $this->section->id,
                'field_id' => $this->moduleFields[2]->id,
                'custom_value' => 'test'
            ]
        )
            ->assertCreated();

        $this->assertEquals('test',CategorySettingsTemplateModuleValue::first()->custom_value);
    }
    /** @test */
    public function can_update_category_template_setting_module_value()
    {
        $categorySettingsTemplateModuleValue =CategorySettingsTemplateModuleValue::factory()->create(
            [
                'field_id' => $this->moduleFields[0]->id,
                'custom_value' => 'test'
            ]
        );
        $this->postJson(route('admin.category-settings-template-module-value.store'),
            [
                'settings_template_id' => $categorySettingsTemplateModuleValue->settings_template_id,
                'module_id' => $categorySettingsTemplateModuleValue->module_id,
                'section_id' => $categorySettingsTemplateModuleValue->section_id,
                'field_id' => $categorySettingsTemplateModuleValue->field_id,
                'custom_value' => 'change'
            ]
        )
            ->assertCreated();

        $this->assertEquals('change',CategorySettingsTemplateModuleValue::first()->custom_value);
    }
}
