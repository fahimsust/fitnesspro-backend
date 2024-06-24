<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use Domain\Products\Models\Category\Category;
use Domain\Sites\Actions\Categories\AddCategoryToSite;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteCategory;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SiteCategoryControllerTest extends ControllerTestCase
{
    public Site $site;
    public Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = Site::factory()->create();
        $this->category = Category::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_remove_category_from_site()
    {
        SiteCategory::factory()->create();

        $this->deleteJson(
            route('admin.site.category.destroy', [$this->site,$this->category])
        )->assertOk();

        $this->assertDatabaseCount(SiteCategory::Table(), 0);
    }

    /** @test */
    public function can_get_site_categories()
    {
        SiteCategory::factory()->create();
        $this->getJson(
            route('admin.site.category.index', [$this->site])
        )->assertOk()->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'title',
                        'subtitle'
                    ]
                ]
            )->assertJsonCount(1);
    }

    /** @test */
    public function can_add_category_to_site()
    {
        $this->postJson(
            route('admin.site.category.store', [$this->site]),
            [
                'category_id' => $this->category->id
            ]
        )
            ->assertCreated()->assertJsonStructure(
                [
                    '*' => [
                        'site_id',
                        'category_id'
                    ]
                ]
            );;
        $this->assertDatabaseCount(SiteCategory::Table(), 1);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {

        $this->postJson(
            route('admin.site.category.store', $this->site),
            [
                'category_id' => 0
            ]
        )
            ->assertJsonValidationErrorFor('category_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(SiteCategory::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(AddCategoryToSite::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(
            route('admin.site.category.store', $this->site),
            [
                'category_id' => $this->category->id
            ]
        )
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(SiteCategory::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(
            route('admin.site.category.store', $this->site),
            [
                'category_id' => $this->category->id
            ]
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(SiteCategory::Table(), 0);
    }
}
