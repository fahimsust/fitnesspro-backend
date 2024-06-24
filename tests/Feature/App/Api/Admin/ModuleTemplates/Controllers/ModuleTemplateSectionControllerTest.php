<?php

namespace Tests\Feature\App\Api\Admin\ModuleTemplates\Controllers;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Modules\Models\ModuleTemplateSection;
use Domain\Sites\Models\Layout\LayoutSection;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ModuleTemplateSectionControllerTest extends ControllerTestCase
{
    private ModuleTemplate $moduleTemplate;
    private LayoutSection $layoutSection;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->moduleTemplate = ModuleTemplate::factory()->create();
        $this->layoutSection = LayoutSection::factory()->create();
    }

    /** @test */
    public function can_create_new_module_template_section()
    {

        $this->postJson(
            route('admin.module-template-section.store'),
            [
                'template_id' => $this->moduleTemplate->id,
                'section_id' =>  $this->layoutSection->id
            ]
        )
            ->assertCreated()
            ->assertJsonStructure(['id', 'section_id']);

        $this->assertDatabaseCount(ModuleTemplateSection::Table(), 1);
    }


    /** @test */
    public function can_delete_module_template_section()
    {
        $moduleTemplateSection = ModuleTemplateSection::factory()->create();

        $this->deleteJson(route('admin.module-template-section.destroy', [$moduleTemplateSection]))
            ->assertOk();

        $this->assertDatabaseCount(ModuleTemplateSection::Table(), 0);
    }

    /** @test */
    public function can_get_module_template_section()
    {
        $moduleTemplate = ModuleTemplate::factory()->create();
        ModuleTemplateSection::factory(15)->create(['template_id' => $this->moduleTemplate->id]);
        ModuleTemplateSection::factory(20)->create(['template_id' => $moduleTemplate->id]);

        $this->getJson(route('admin.module-template-section.index', ['template_id' => $this->moduleTemplate->id]))
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
            route('admin.module-template-section.store'),
            [
                'template_id' => $this->moduleTemplate->id,
            ]
        )
            ->assertJsonValidationErrorFor('section_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ModuleTemplateSection::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();
        ModuleTemplateSection::factory(15)->create();
        $this->getJson(route('admin.module-template-section.index'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
