<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettingsModuleValue;
use Illuminate\Database\Eloquent\Collection;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SiteSettingModuleValueControllerTest extends ControllerTestCase
{
    private Site $site;
    private LayoutSection $section;
    private Module $module;
    private Collection $moduleFields;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->site = Site::factory()->create();
        $this->section = LayoutSection::factory()->create(['rank' => 1]);
        $this->module = Module::factory()->create();
        $this->moduleFields = ModuleField::factory(5)->create();

    }

    /** @test */
    public function can_get_product_module_section()
    {
        SiteSettingsModuleValue::factory()->create(
            [
                'section'=>'Home',
                'field_id' => $this->moduleFields[0]->id,
                'custom_value' => 'first'
            ]
        );
        SiteSettingsModuleValue::factory()->create(
            [
                'section'=>'Home',
                'field_id' => $this->moduleFields[1]->id,
                'custom_value' => 'second'
            ]
        );
        $result = $this->getJson(route('admin.site.module-value.index', [
            'site_id' => $this->site->id,
            'section' => 'Home',
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
    public function can_add_product_site_setting_module_value()
    {
        $this->postJson(route('admin.site.module-value.store'),
            [
                'site_id' => $this->site->id,
                'section' => "Home",
                'module_id' => $this->module->id,
                'section_id' => $this->section->id,
                'field_id' => $this->moduleFields[2]->id,
                'custom_value' => 'test'
            ]
        )
            ->assertCreated();

        $this->assertEquals('test',SiteSettingsModuleValue::first()->custom_value);
    }
    /** @test */
    public function can_update_product_site_setting_module_value()
    {
        $siteSettingsModuleValue = SiteSettingsModuleValue::factory()->create(
            [
                'field_id' => $this->moduleFields[0]->id,
                'custom_value' => 'test'
            ]
        );
        $this->postJson(route('admin.site.module-value.store'),
            [
                'site_id' => $siteSettingsModuleValue->site_id,
                'section' => $siteSettingsModuleValue->section,
                'module_id' => $siteSettingsModuleValue->module_id,
                'section_id' => $siteSettingsModuleValue->section_id,
                'field_id' => $siteSettingsModuleValue->field_id,
                'custom_value' => 'change'
            ]
        )
            ->assertCreated();

        $this->assertEquals('change',SiteSettingsModuleValue::first()->custom_value);
    }
}
