<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategorySettingsSiteModuleValue;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategorySiteSettingModuleValueControllerTest extends ControllerTestCase
{
    private Site $site;
    private Category $category;
    private LayoutSection $section;
    private Module $module;
    private Collection $moduleFields;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->site = Site::factory()->create();
        $this->category = Category::factory()->create();
        $this->section = LayoutSection::factory()->create(['rank' => 1]);
        $this->module = Module::factory()->create();
        $this->moduleFields = ModuleField::factory(5)->create();

    }

    /** @test */
    public function can_get_category_module_section()
    {
        CategorySettingsSiteModuleValue::factory()->create(
            [
                'field_id' => $this->moduleFields[0]->id,
                'custom_value' => 'first'
            ]
        );
        CategorySettingsSiteModuleValue::factory()->create(
            [
                'field_id' => $this->moduleFields[1]->id,
                'custom_value' => 'second'
            ]
        );
        $result = $this->getJson(route('admin.category-module-value.index', [
            'site_id' => $this->site->id,
            'category_id' => $this->category->id,
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
    public function can_add_category_site_setting_module_value()
    {
        $this->postJson(route('admin.category-module-value.store'),
            [
                'site_id' => $this->site->id,
                'category_id' => $this->category->id,
                'module_id' => $this->module->id,
                'section_id' => $this->section->id,
                'field_id' => $this->moduleFields[2]->id,
                'custom_value' => 'test'
            ]
        )
            ->assertCreated();

        $this->assertEquals('test',CategorySettingsSiteModuleValue::first()->custom_value);
    }
    /** @test */
    public function can_update_category_site_setting_module_value()
    {
        $categorySettingsSiteModuleValue =CategorySettingsSiteModuleValue::factory()->create(
            [
                'field_id' => $this->moduleFields[0]->id,
                'custom_value' => 'test'
            ]
        );
        $this->postJson(route('admin.category-module-value.store'),
            [
                'site_id' => $categorySettingsSiteModuleValue->site_id,
                'category_id' => $categorySettingsSiteModuleValue->category_id,
                'module_id' => $categorySettingsSiteModuleValue->module_id,
                'section_id' => $categorySettingsSiteModuleValue->section_id,
                'field_id' => $categorySettingsSiteModuleValue->field_id,
                'custom_value' => 'change'
            ]
        )
            ->assertCreated();

        $this->assertEquals('change',CategorySettingsSiteModuleValue::first()->custom_value);
    }
}
