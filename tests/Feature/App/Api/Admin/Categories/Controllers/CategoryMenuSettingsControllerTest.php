<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryMenuSettingsRequest;
use Domain\Products\Actions\Categories\Settings\UpdateCategoryMenuSettings;
use Domain\Products\Models\Category\Category;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryMenuSettingsControllerTest extends ControllerTestCase
{
    public Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_category_menu_setting()
    {
        CategoryMenuSettingsRequest::fake(['rank' => 100]);

        $this->postJson(route('admin.category.menu-setting.store', [$this->category]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals(100, $this->category->refresh()->rank);
    }

    /** @test */
    public function can_get_category_menu_setting()
    {
        $this->getJson(route('admin.category.menu-setting.index', [$this->category]))
            ->assertOk()
            ->assertJsonStructure([
                'rank',
                'show_in_list',
                'menu_class'
            ]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        CategoryMenuSettingsRequest::fake(['rank' => '']);

        $this->postJson(route('admin.category.menu-setting.store', [$this->category]))
            ->assertJsonValidationErrorFor('rank')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateCategoryMenuSettings::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        CategoryMenuSettingsRequest::fake();

        $this->postJson(route('admin.category.menu-setting.store', [$this->category]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CategoryMenuSettingsRequest::fake();

        $this->postJson(route('admin.category.menu-setting.store', [$this->category]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
