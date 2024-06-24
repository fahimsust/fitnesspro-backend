<?php

namespace Tests\Feature\App\Api\Admin\ModuleTemplates\Controllers;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Modules\Models\ModuleTemplateModule;
use Domain\Modules\Models\ModuleTemplateSection;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ModuleTemplateControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_module_template()
    {

        $this->postJson(
            route('admin.module-template.store'),
            ['name' => 'test', 'parent_template_id' => ModuleTemplate::firstOrFactory()->id]
        )
            ->assertCreated()
            ->assertJsonStructure(['id', 'name']);

        $this->assertDatabaseCount(ModuleTemplate::Table(), 2);
    }
    /** @test */
    public function can_update_module_template()
    {
        $moduleTemplate = ModuleTemplate::factory()->create();

        $this->putJson(
            route('admin.module-template.update', [$moduleTemplate]),
            ['name' => 'test', 'parent_template_id' => ModuleTemplate::firstOrFactory()->id]
        )
            ->assertCreated();

        $this->assertEquals('test', $moduleTemplate->refresh()->name);
    }

    /** @test */
    public function can_delete_module_template()
    {
        $moduleTemplate = moduleTemplate::factory()->create();

        $this->deleteJson(route('admin.module-template.destroy', [$moduleTemplate->first()]))
            ->assertOk();

        $this->assertDatabaseCount(moduleTemplate::Table(), 0);
    }

    /** @test */
    public function can_get_module_template()
    {
        ModuleTemplate::factory(15)->create();

        $this->getJson(route('admin.module-template.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])->assertJsonCount(15);
    }
    /** @test */
    public function can_get_message_template_list()
    {
        ModuleTemplate::factory(30)->create();

        $response = $this->getJson(route('admin.module-templates.list', ["per_page" => 5, "page" => 2]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])
            ->assertJsonCount(5, 'data');
        $this->assertEquals(2, $response['current_page']);
    }

    /** @test */
    public function can_get_module_template_section_module()
    {
        $moduleTemplate = ModuleTemplate::factory()->create();
        ModuleTemplateSection::factory()->create();
        ModuleTemplateModule::factory()->create();

        $data = $this->getJson(
            route('admin.module-template.show', [$moduleTemplate->id])
        )->assertJsonStructure([
            'id',
            'name',
            'module_template_sections' => [
                '*' => [
                    'modules_templates_modules' => [
                        "*" => [
                            "module"
                        ]
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function can_search_message_template()
    {
        ModuleTemplate::factory()->create(['name' => 'test1']);
        ModuleTemplate::factory()->create(['name' => 'test2']);
        ModuleTemplate::factory()->create(['name' => 'not_match']);

        $this->getJson(
            route('admin.module-templates.list', ["per_page" => 5, "page" => 1, 'keyword' => 'test']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])->assertJsonCount(2, 'data');
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();
        ModuleTemplate::factory(15)->create();
        $this->getJson(route('admin.module-template.index'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
