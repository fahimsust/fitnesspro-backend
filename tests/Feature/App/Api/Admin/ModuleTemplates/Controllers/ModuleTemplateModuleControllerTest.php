<?php

namespace Tests\Feature\App\Api\Admin\ModuleTemplates\Controllers;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Modules\Models\ModuleTemplateModule;
use Domain\Modules\Models\ModuleTemplateSection;
use Domain\Sites\Models\Layout\LayoutSection;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ModuleTemplateModuleControllerTest extends ControllerTestCase
{
    private ModuleTemplate $moduleTemplate;
    private LayoutSection $layoutSection;

    private Module $module;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->moduleTemplate = ModuleTemplate::factory()->create();
        $this->layoutSection = LayoutSection::factory()->create();
        $this->module = Module::factory()->create();
    }

    /** @test */
    public function can_create_new_module_template_module()
    {

        $this->postJson(
            route('admin.module-template-module.store'),
            [
                'template_id' => $this->moduleTemplate->id,
                'section_id' =>  $this->layoutSection->id,
                'module_id' =>  $this->module->id
            ]
        )
            ->assertCreated()
            ->assertJsonStructure(['id', 'section_id']);

        $this->assertDatabaseCount(ModuleTemplateModule::Table(), 1);
    }

    /** @test */
    public function can_update_module_template_module()
    {
        $moduleTemplateModule = ModuleTemplateModule::factory()->create(['rank' => 1]);

        $this->putJson(
            route('admin.module-template-module.update', [$moduleTemplateModule]),
            ['rank' => 10]
        )
            ->assertOk();

        $this->assertEquals(10, $moduleTemplateModule->refresh()->rank);
    }



    /** @test */
    public function can_delete_module_template_module()
    {
        $moduleTemplateModule = ModuleTemplateModule::factory()->create();

        $this->deleteJson(route('admin.module-template-module.destroy', [$moduleTemplateModule]))
            ->assertOk();

        $this->assertDatabaseCount(ModuleTemplateModule::Table(), 0);
    }

    /** @test */
    public function can_get_module_template_module()
    {
        $moduleTemplate = ModuleTemplate::factory()->create();
        ModuleTemplateModule::factory(15)->create(['template_id' => $this->moduleTemplate->id, 'section_id' => $this->layoutSection->id]);
        ModuleTemplateModule::factory(20)->create(['template_id' => $moduleTemplate->id, 'section_id' => $this->layoutSection->id]);

        $this->getJson(route('admin.module-template-module.index', ['template_id' => $this->moduleTemplate->id, 'section_id' => $this->layoutSection->id]))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'section_id',
                ]
            ])->assertJsonCount(15);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {

        $this->postJson(
            route('admin.module-template-module.store'),
            [
                'template_id' => $this->moduleTemplate->id,
                'section_id' =>  $this->layoutSection->id,
            ]
        )
            ->assertJsonValidationErrorFor('module_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ModuleTemplateSection::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();
        ModuleTemplateSection::factory(15)->create();
        $this->postJson(
            route('admin.module-template-module.store'),
            [
                'template_id' => $this->moduleTemplate->id,
                'section_id' =>  $this->layoutSection->id,
                'module_id' =>  $this->module->id
            ]
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
