<?php

namespace Tests\Feature\App\Api\Admin\CategorySettingsTemplates\Controllers;

use App\Api\Admin\CategorySettingsTemplates\Requests\CategorySettingsTemplateRequest;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategorySettingsTemplateControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_layout()
    {
        CategorySettingsTemplate::factory(15)->create();

        $this->getJson(route('admin.category-settings-template.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'layout_id',
                ]
            ])->assertJsonCount(15);
    }

    /** @test */
    public function can_create_new_category_setting_template()
    {
        CategorySettingsTemplateRequest::fake();
        $this->postJson(route('admin.category-settings-template.store'))
            ->assertCreated()
            ->assertJsonStructure(['id', 'layout_id']);

        $this->assertDatabaseCount(CategorySettingsTemplate::Table(), 1);
    }
    /** @test */
    public function can_update_category_setting_template()
    {
        $categorySettingsTemplate = CategorySettingsTemplate::factory()->create();
        CategorySettingsTemplateRequest::fake(['name' => 'test']);

        $this->putJson(route(
            'admin.category-settings-template.update',
            [$categorySettingsTemplate]
        ))
            ->assertCreated();

        $this->assertEquals('test', $categorySettingsTemplate->refresh()->name);
    }

    /** @test */
    public function can_delete_category_setting_template()
    {
        $categorySettingsTemplate = CategorySettingsTemplate::factory(5)->create();

        $this->deleteJson(route('admin.category-settings-template.destroy', [$categorySettingsTemplate->first()]))
            ->assertOk();

        $this->assertDatabaseCount(CategorySettingsTemplate::Table(), 4);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();
        CategorySettingsTemplate::factory(15)->create();
        $this->getJson(route('admin.category-settings-template.index'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
