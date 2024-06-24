<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Actions\Categories\Settings\UpdateCategorySettingsTemplateForSite;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Domain\Products\Models\Category\CategorySiteSettings;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategorySiteSettingsControllerTest extends ControllerTestCase
{
    public Category $category;
    public CategorySettingsTemplate $categorySettingsTemplate;
    public CategorySiteSettings $categorySiteSettings;
    public ModuleTemplate $moduleTemplate;
    private Site $site;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->site = Site::factory()->create(['id' => config('site.id')]);
        $this->category = Category::factory()->create();
        $this->categorySettingsTemplate = CategorySettingsTemplate::factory()->create();
        $this->categorySiteSettings = CategorySiteSettings::factory()->create();
        $this->moduleTemplate = ModuleTemplate::factory()->create();
    }

    /** @test */
    public function get_category_site_settings()
    {
        CategorySiteSettings::factory()->create(['site_id' => null, 'category_id' => $this->category->id]);
        Site::factory()->create();

        $this->getJson(route('admin.category.settings-template.site.index', $this->category))
            ->assertOk()
            ->assertJsonStructure(['*' => ['site_id', 'name', 'settings']])
            ->assertJsonCount(3);
    }

    /** @test */
    public function can_update_settings_template_id_for_site()
    {
        $this->postJson(
            route('admin.category.settings-template.site.store', [$this->category]),
            [
                "settings_template_id" => $this->categorySettingsTemplate->id,
                'site_id' => $this->site->id,
                'settings_template_id_default' => 1,
                "module_template_id" => $this->moduleTemplate->id,
                'module_template_id_default' => 1
            ]
        )
            ->assertCreated()
            ->assertJsonStructure(['settings_template_id', 'category_id', 'site_id']);

        $this->assertEquals($this->categorySettingsTemplate->id, $this->categorySiteSettings->refresh()->settings_template_id);
        $this->assertEquals($this->moduleTemplate->id, $this->categorySiteSettings->refresh()->module_template_id);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('admin.category.settings-template.site.store', [$this->category, $this->site]),
            ["settings_template_id" => 0]
        )
            ->assertJsonValidationErrorFor('settings_template_id')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateCategorySettingsTemplateForSite::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(
            route('admin.category.settings-template.site.store', [$this->category]),
            ["settings_template_id" => $this->categorySettingsTemplate->id, 'site_id' => $this->site->id, 'settings_template_id_default' => 1]
        )
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertNotEquals($this->categorySettingsTemplate->id, $this->categorySiteSettings->refresh()->settings_template_id);
    }

    /** @test */
    public function type_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(
            route('admin.category.settings-template.site.store', [$this->category]),
            ["settings_template_id" => $this->categorySettingsTemplate->id, 'site_id' => $this->site->id, 'settings_template_id_default' => 1]
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
        $this->assertNotEquals($this->categorySettingsTemplate->id, $this->categorySiteSettings->refresh()->settings_template_id);
    }
}
