<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use Domain\Products\Actions\Categories\Settings\UpdateCategorySettingsTemplate;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategorySettings;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategorySettingsControllerTest extends ControllerTestCase
{
    public Category $category;
    public CategorySettingsTemplate $categorySettingsTemplate;
    public CategorySettings $categorySettings;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        Site::factory()->create(['id' => config('site.id')]);
        $this->category = Category::factory()->create();
        $this->categorySettingsTemplate = CategorySettingsTemplate::factory()->create();
        $this->categorySettings = CategorySettings::factory()->create();
    }

    /** @test */
    public function get_category_settings()
    {

        $this->getJson(route('admin.category.settings-template.index', $this->category))
        ->assertOk()
        ->assertJsonStructure(['settings_template_id']);
    }

    /** @test */
    public function can_update_settings_template_id()
    {
        $this->postJson(
            route('admin.category.settings-template.store', $this->category),
            ["settings_template_id" => $this->categorySettingsTemplate->id]
        )
            ->assertCreated()
            ->assertJsonStructure(['settings_template_id', 'category_id']);

        $this->assertEquals($this->categorySettingsTemplate->id, $this->categorySettings->refresh()->settings_template_id);
    }
    /** @test */
    public function can_update_settings_template_id_without_category_settings()
    {
        $this->categorySettings->delete();
        $this->postJson(
            route('admin.category.settings-template.store', $this->category),
            ["settings_template_id" => $this->categorySettingsTemplate->id]
        )
            ->assertCreated()
            ->assertJsonStructure(['settings_template_id', 'category_id']);

        $this->assertDatabaseCount(CategorySettings::Table(), 1);
        $this->assertEquals($this->categorySettingsTemplate->id, CategorySettings::first()->settings_template_id);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('admin.category.settings-template.store', $this->category),
            ["settings_template_id" => 0]
        )
            ->assertJsonValidationErrorFor('settings_template_id')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateCategorySettingsTemplate::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(
            route('admin.category.settings-template.store', $this->category),
            ["settings_template_id" => $this->categorySettingsTemplate->id]
        )
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertNotEquals($this->categorySettingsTemplate->id, $this->categorySettings->refresh()->settings_template_id);
    }

    /** @test */
    public function type_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(
            route('admin.category.settings-template.store', $this->category),
            ["settings_template_id" => $this->categorySettingsTemplate->id]
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
        $this->assertNotEquals($this->categorySettingsTemplate->id, $this->categorySettings->refresh()->settings_template_id);
    }
}
