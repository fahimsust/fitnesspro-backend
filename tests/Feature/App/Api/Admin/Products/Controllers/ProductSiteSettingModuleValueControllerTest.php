<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\Settings\ProductSiteSettingsModuleValue;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductSiteSettingModuleValueControllerTest extends ControllerTestCase
{
    private Site $site;
    private Product $product;
    private LayoutSection $section;
    private Module $module;
    private Collection $moduleFields;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->site = Site::factory()->create();
        $this->product = Product::factory()->create();
        $this->section = LayoutSection::factory()->create(['rank' => 1]);
        $this->module = Module::factory()->create();
        $this->moduleFields = ModuleField::factory(5)->create();

    }

    /** @test */
    public function can_get_product_module_section()
    {
        ProductSiteSettingsModuleValue::factory()->create(
            [
                'field_id' => $this->moduleFields[0]->id,
                'custom_value' => 'first'
            ]
        );
        ProductSiteSettingsModuleValue::factory()->create(
            [
                'field_id' => $this->moduleFields[1]->id,
                'custom_value' => 'second'
            ]
        );
        $result = $this->getJson(route('admin.product-module-value.index', [
            'site_id' => $this->site->id,
            'product_id' => $this->product->id,
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
        $this->postJson(route('admin.product-module-value.store'),
            [
                'site_id' => $this->site->id,
                'product_id' => $this->product->id,
                'module_id' => $this->module->id,
                'section_id' => $this->section->id,
                'field_id' => $this->moduleFields[2]->id,
                'custom_value' => 'test'
            ]
        )
            ->assertCreated();

        $this->assertEquals('test',ProductSiteSettingsModuleValue::first()->custom_value);
    }
    /** @test */
    public function can_update_product_site_setting_module_value()
    {
        $productSiteSettingsModuleValue =ProductSiteSettingsModuleValue::factory()->create(
            [
                'field_id' => $this->moduleFields[0]->id,
                'custom_value' => 'test'
            ]
        );
        $this->postJson(route('admin.product-module-value.store'),
            [
                'site_id' => $productSiteSettingsModuleValue->site_id,
                'product_id' => $productSiteSettingsModuleValue->product_id,
                'module_id' => $productSiteSettingsModuleValue->module_id,
                'section_id' => $productSiteSettingsModuleValue->section_id,
                'field_id' => $productSiteSettingsModuleValue->field_id,
                'custom_value' => 'change'
            ]
        )
            ->assertCreated();

        $this->assertEquals('change',ProductSiteSettingsModuleValue::first()->custom_value);
    }
}
