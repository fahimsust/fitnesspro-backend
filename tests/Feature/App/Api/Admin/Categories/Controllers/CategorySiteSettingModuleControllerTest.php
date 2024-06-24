<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Modules\Models\ModuleTemplateModule;
use Domain\Modules\Models\ModuleTemplateSection;
use Domain\Sites\Models\Layout\LayoutSection;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategorySiteSettingModuleControllerTest extends ControllerTestCase
{
    public ModuleTemplate $moduleTemplate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $parentModule = ModuleTemplate::factory()->create();
        $parentModule2 = ModuleTemplate::factory()->create(['parent_template_id'=>$parentModule->id]);
        $this->moduleTemplate = ModuleTemplate::factory()->create(['parent_template_id'=>$parentModule2->id]);
        $layoutSections1 =LayoutSection::factory()->create(['rank'=>1]);
        $layoutSections2 =LayoutSection::factory()->create(['rank'=>2]);
        $layoutSections3 =LayoutSection::factory()->create(['rank'=>3]);
        $layoutSections4 =LayoutSection::factory()->create(['rank'=>4]);
        $layoutSections5 =LayoutSection::factory()->create(['rank'=>5]);
        ModuleTemplateSection::factory()->create(['template_id'=>$parentModule->id,'section_id'=>$layoutSections1->id]);
        ModuleTemplateSection::factory()->create(['template_id'=>$parentModule2->id,'section_id'=>$layoutSections1->id]);
        ModuleTemplateSection::factory()->create(['template_id'=>$this->moduleTemplate,'section_id'=>$layoutSections1->id]);
        ModuleTemplateSection::factory()->create(['template_id'=>$this->moduleTemplate,'section_id'=>$layoutSections2->id]);
        ModuleTemplateSection::factory()->create(['template_id'=>$parentModule->id,'section_id'=>$layoutSections3->id]);
        ModuleTemplateSection::factory()->create(['template_id'=>$parentModule2->id,'section_id'=>$layoutSections5->id]);
        ModuleTemplateSection::factory()->create(['template_id'=>$parentModule->id,'section_id'=>$layoutSections5->id]);

        $modules = Module::factory(10)->create();

        ModuleTemplateModule::factory()->create(['template_id'=>$parentModule->id,'section_id'=>$layoutSections1->id,'module_id'=>$modules[0]->id]);
        ModuleTemplateModule::factory()->create(['template_id'=>$parentModule2->id,'section_id'=>$layoutSections1->id,'module_id'=>$modules[0]->id]);
        ModuleTemplateModule::factory()->create(['template_id'=>$parentModule2->id,'section_id'=>$layoutSections1->id,'module_id'=>$modules[1]->id]);
        ModuleTemplateModule::factory()->create(['template_id'=>$parentModule->id,'section_id'=>$layoutSections2->id,'module_id'=>$modules[2]->id]);
        ModuleTemplateModule::factory()->create(['template_id'=>$parentModule2->id,'section_id'=>$layoutSections3->id,'module_id'=>$modules[3]->id]);
        ModuleTemplateModule::factory()->create(['template_id'=>$this->moduleTemplate,'section_id'=>$layoutSections4->id,'module_id'=>$modules[4]->id]);

        ModuleTemplateModule::factory()->create(['template_id'=>$this->moduleTemplate,'section_id'=>$layoutSections5->id,'module_id'=>$modules[5]->id]);
        ModuleTemplateModule::factory()->create(['template_id'=>$this->moduleTemplate,'section_id'=>$layoutSections5->id,'module_id'=>$modules[6]->id]);
        ModuleTemplateModule::factory()->create(['template_id'=>$this->moduleTemplate,'section_id'=>$layoutSections5->id,'module_id'=>$modules[7]->id]);
        ModuleTemplateModule::factory()->create(['template_id'=>$parentModule2->id,'section_id'=>$layoutSections5->id,'module_id'=>$modules[5]->id]);


    }

    /** @test */
    public function can_get_product_module_section()
    {
        $result = $this->getJson(route('admin.category-module.sections',['module_template_id'=>$this->moduleTemplate] ))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'sections',
                    'modules',
                ]
            ])->assertJsonCount(4);
            $this->assertCount(3,$result[3]['modules']);
    }


}
