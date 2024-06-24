<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryFilterSettingsRequest;
use Domain\Products\Actions\Categories\Settings\UpdateCategoryFilterSettings;
use Domain\Products\Models\Category\Category;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryFilterSettingsControllerTest extends ControllerTestCase
{
    public Category $category;
    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_category_filter()
    {
        CategoryFilterSettingsRequest::fake(['max_price' => 100]);

        $this->postJson(
            route('admin.category.filter.store', [$this->category])
        )
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals(100,$this->category->refresh()->max_price);
    }

    /** @test */
    public function can_get_category_filter()
    {
        $this->getJson(route('admin.category.filter.index', [$this->category]))
            ->assertOk()
            ->assertJsonStructure([
                'show_sale',
                'limit_min_price',
                'min_price',
                'limit_max_price',
                'max_price',
                'show_in_list',
                'limit_days',
                'show_types',
                'show_brands',
                'rules_match_type',
            ]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        CategoryFilterSettingsRequest::fake(['rules_match_type' => '']);

        $this->postJson(route('admin.category.filter.store', [$this->category]))
            ->assertJsonValidationErrorFor('rules_match_type')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateCategoryFilterSettings::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        CategoryFilterSettingsRequest::fake();

        $this->postJson(route('admin.category.filter.store', [$this->category]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CategoryFilterSettingsRequest::fake();

        $this->postJson(route('admin.category.filter.store', [$this->category]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
